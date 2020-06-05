<?php

namespace App\Console\Commands;

use App\CallForProjects;
use App\Perimeter;
use App\ProjectHolder;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportRegion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'region:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe dans la base de données les aides disponibles via les flux RSS du site https://les-aides.nouvelle-aquitaine.fr/';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $thematics_region = array(
            'acces-a-la-pratique-sportive'              => 'Autre',
            'amenagement-numerique'                     => 'Aménagement numérique du territoire',
            'economie-territoriale'                     => 'Economie sociale et solidaire (ESS)',
            'egalite'                                   => 'Autre',
            'europe-et-international'                   => 'Autre',
            'foncier'                                   => 'Autre',
            'ligues-et-comites'                         => 'Autre',
            'logement'                                  => 'Autre',
            'manifestations-et-equipements-sportifs'    => 'Autre',
            'sante'                                     => 'Autre',
            'silver-economie'                           => 'Autre',
            'solidarite'                                => 'Autre',
            'sport'                                     => 'Autre',
            'sport-de-haut-niveau'                      => 'Autre',
            'transports'                                => 'Transport - Mobilité + Sécurité routière',
            'vie-associative'                           => 'Autre',
            'arts-plastiques-et-visuels'                => 'Tourisme - Culture',
            'cinema-et-audiovisuel'                     => 'Tourisme - Culture',
            'disque'                                    => 'Tourisme - Culture',
            'education-artistique-et-culturelle'        => 'Tourisme - Culture',
            'equipements-culturels'                     => 'Tourisme - Culture',
            'langues-et-cultures-regionales'            => 'Tourisme - Culture',
            'livre'                                     => 'Tourisme - Culture',
            'manifestations-culturelles'                => 'Tourisme - Culture',
            'patrimoine-et-inventaire'                  => 'Tourisme - Culture',
            'spectacle-vivant'                          => 'Tourisme - Culture',
            'aeronautique'                              => 'Economie sociale et solidaire (ESS)',
            'agriculture'                               => 'Agriculture - Alimentation',
            'agroalimentaire'                           => 'Agriculture - Alimentation',
            'artisanat'                                 => 'Autre',
            'bio'                                       => 'Autre',
            'bois'                                      => 'Forêt - Bois',
            'chimie'                                    => 'Autre',
            'creation-demplois'                         => 'Economie sociale et solidaire (ESS)',
            'creation-et-reprise-dentreprise'           => 'Autre',
            'cuir,-luxe'                                => 'Economie sociale et solidaire (ESS)',
            'developpement-international'               => 'Autre',
            'economie-culturelle'                       => 'Tourisme - Culture',
            'emploi'                                    => 'Autre',
            'ess'                                       => 'Économie Sociale et Solidaire (ESS)',
            'export'                                    => 'Autre',
            'filieres'                                  => 'Autre',
            'financement'                               => 'Autre',
            'foret'                                     => 'Forêt - Bois',
            'formation-professionnelle'                 => 'Autre',
            'innovation'                                => 'Autre',
            'numerique'                                 => 'Aménagement numérique du territoire',
            'peche'                                     => 'Autre',
            'performance-et-competitivite'              => 'Autre',
            'photonique'                                => 'Autre',
            'recherche'                                 => 'Autre',
            'start-up'                                  => 'Autre',
            'tourisme'                                  => 'Tourisme - Culture',
            'transmission-et-mutation-dactivite'        => 'Autre',
            'accompagnement-scolaire'                   => 'Autre',
            'apprentissage'                             => 'Autre',
            'citoyennete'                               => 'Autre',
            'education'                                 => 'Autre',
            'enseignement-superieur'                    => 'Autre',
            'formation'                                 => 'Autre',
            'insertion-professionnelle'                 => 'Autre',
            'lycees'                                    => 'Autre',
            'mobilite-internationale'                   => 'Transport - Mobilité + Sécurité routière',
            'orientation'                               => 'Autre',
            'sanitaire-et-social'                       => 'Autre',
            'biodiversite'                              => 'Biodiversité',
            'climat'                                    => 'Énergie, air et climat',
            'dechets'                                   => 'Économie verte et circulaire  (Déchets, EIT, recyclage, collecte, écoconditionnalité, ...)',
            'economie-circulaire'                       => 'Economie sociale et solidaire (ESS)',
            'economies-denergie'                        => 'Énergie, air et climat',
            'energies-renouvelables'                    => 'Énergie, air et climat',
            'environnement'                             => 'Autre',
            'littoral'                                  => 'Mer et littoral',
        );

        $nbImport = 0;

        
        $this->info('Starting...');

        $i = 0;
        $total = sizeof($thematics_region);
        
        foreach ($thematics_region as $slug => $thematic)
        {
            $this->info('Thematic '.$i.'/'.$total);
            $uri = 'https://les-aides.nouvelle-aquitaine.fr/fiches-rss/'.$slug.'/rss.xml';
            $xml = $this->getXML($uri);

            foreach ($xml->channel->item as $item)
            {
                $callForProject = CallForProjects::fromBatch($item, $thematic);
                if ($this->callForProjectDoesntExist($callForProject->website_url))
                {
                    $callForProject->save();
                    
                    $perimetre = Perimeter::where('name', 'Nouvelle - Aquitaine')->first();
                    $perimetre->callsForProjects()->attach($callForProject->id);
                    $perimetre->save();

                    $projectHolder = ProjectHolder::where('name', 'Région Nouvelle-Aquitaine')->first();
                    $projectHolder->callsForProjects()->attach($callForProject->id);
                    $projectHolder->save();

                    $nbImport++;
                    $this->info('Imports: '.$nbImport);
                }
            }
            $i++;
        }
        
        $this->info($nbImport.' calls for projects imported from batch');
    }

    private function callForProjectDoesntExist($website_url) {
        return CallForProjects::where('website_url', $website_url)->count() < 1;
    }

    private function getXML($uri)
    {
        $client = new Client();
        $response = $client->get($uri);
        $content = $response->getBody();
        $xml = \simplexml_load_string($content->read($content->getSize()));
        return $xml;
    }
}
