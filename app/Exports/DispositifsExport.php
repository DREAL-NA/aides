<?php

namespace App\Exports;

use App\Resources\CallsForProjects;

class DispositifsExport extends GlobalExport implements GlobalExportInterface
{
    protected $columns = array(
        // These names are chosen to ease reuse and match existing similar datasets.
        // See https://www.ademe.fr/sites/default/files/assets/documents/aides_financieres_-_description_du_jeu_de_donnees_.pdf and https://github.com/MTES-MCT/aides-territoires/blob/9dd1ba9dcd076a6406c6684bbd907a04ad8f22d7/src/aids/models.py
        'thematique' => 'Thématique du dispositif.',
        'sousThematique' => 'Sous-thématique du dispositif.',
        'titre' => 'Nom du dispositif.',
        'dateCloture' => 'Date maximale à laquelle la demande d’attribution doit être envoyée, au format ISO (AAAA-MM-JJ).',  // ISO format used for dates in ADEME dataset
        'nomAttribuant' => 'Nom de l’organisme attribuant la subvention ou émettant l’appel à projets.',  // used in ADEME dataset
        'perimetres' => 'Périmètre géographique ou administratif du dispositif.',
        'objet' => 'Description des objectifs du dispositif.',  // used in ADEME dataset
        'publicsBeneficiaires' => 'Types d’acteurs éligibles au dispositif.',
        'publicsBeneficiairesDetails' => 'Conditions supplémentaires d’éligibilité au dispositif.',
        'dotationMontant' => 'Montant de l’éventuelle dotation financière du dispositif, dans un format textuel non normalisé.',
        'dotationDetails' => 'Modalités d’attribution de la dotation.',
        'contactDREALDDTMs' => 'Contact technique au sein de la DREAL.',
        'contactAttribuant' => 'Contact au sein de l’organisme attribuant la subvention ou émettant l’appel à projets.',
        'URL' => 'Adresse web à laquelle des détails supplémentaires peuvent être obtenus sur le dispositif.'
    );

    protected function filename()
    {
        return 'dispositifs_' . date('YmdHis');
    }

    public function columnsWithDescription()
    {
      return $this->columns;
    }

    public function collection()
    {
        return (new CallsForProjects())->get()->map(function ($item) {
            $allocations = [];
            if (!empty($item->allocation_global)) {
                $allocations[] = 'Globale';
            }
            if (!empty($item->allocation_per_project)) {
                $allocations[] = 'Par projet';
            }

            // All allocations' info are merged as today without allocation comments it's impossible for the user to know if the amount is global or per project.
            // It will be better to have two amount available, one per project and a global one.
            $alloc_text = implode("\n", $allocations);
            if (!empty($item->allocation_amount)) {
                $alloc_text .= "\n" . $item->allocation_amount;
            }
            if (!empty($item->allocation_comments)) {
                $alloc_text .= "\n" . $item->allocation_comments;
            }

            return [
                $item->thematic->name,
                empty($item->subthematic) ? '' : $item->subthematic->name,
                $item->name,
                empty($item->closing_date) ? '' : $item->closing_date->format('Y-m-d'),
                empty($item->projectHolders) ? '' : implode(', ', $item->projectHolders->pluck('name')->all()),
                empty($item->perimeters) ? '' : implode(', ', $item->perimeters->pluck('name')->all()),
                $item->objectives,
                empty($item->beneficiaries) ? '' : implode(', ', $item->beneficiaries->pluck('name_complete')->all()),
                $item->beneficiary_comments,
                $item->allocation_amount,
                $alloc_text,
                $item->technical_relay,
                $item->project_holder_contact,
                $item->website_url,
            ];
        });
    }
}
