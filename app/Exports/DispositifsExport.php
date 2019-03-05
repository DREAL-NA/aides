<?php

namespace App\Exports;

use App\CallForProjects;
use App\Resources\CallsForProjects;

class DispositifsExport extends GlobalExport implements GlobalExportInterface
{
    protected $columns = [
        // These names are chosen to ease reuse and match existing similar datasets.
        // See https://www.ademe.fr/sites/default/files/assets/documents/aides_financieres_-_description_du_jeu_de_donnees_.pdf and https://github.com/MTES-MCT/aides-territoires/blob/9dd1ba9dcd076a6406c6684bbd907a04ad8f22d7/src/aids/models.py
        'thematique' => "Thématique de l'aide.",
        'sousThematique' => "Sous-thématique de l'aide.",
        'titre' => "Nom de l'aide.",
        'dateCloture' => "Date maximale à laquelle la demande d’attribution doit être envoyée, au format ISO (AAAA-MM-JJ).",
        // ISO format used for dates in ADEME dataset
        'nomAttribuant' => "Nom de l’organisme attribuant la subvention ou émettant l’appel à projets.",
        // used in ADEME dataset
        'perimetres' => "Localisation géographique ou administratif de l'aide.",
        'objet' => "Description des objectifs de l'aide.",
        // used in ADEME dataset
        'publicsBeneficiaires' => "Types d’acteurs éligibles à l'aide.",
        'publicsBeneficiairesDetails' => "Conditions supplémentaires d’éligibilité à l'aide.",
        'dotationMontant' => "Montant de l’éventuelle dotation financière de l'aide, dans un format textuel non normalisé.",
        'dotationDetails' => "Modalités d’attribution de la dotation.",
        'contactDREALDDTMs' => "Contact technique au sein de la DREAL.",
        'contactAttribuant' => "Contact au sein de l’organisme attribuant la subvention ou émettant l’appel à projets.",
        'URL' => "Adresse web à laquelle des détails supplémentaires peuvent être obtenus sur l'aide."
    ];

    protected $withDates = false;

    public function __construct($params = null)
    {
        if (isset($params['withDates'])) {
            $this->withDates = $params['withDates'];
        }

        $this->setWithDates();
        $this->setColumns();
    }

    protected function filename()
    {
        return 'aides_' . date('YmdHis');
    }

    public function columnsWithDescription()
    {
        return $this->columns;
    }

    public function collection()
    {
        if (!request()->has('query')) {
            $result = CallForProjects::with([
                'thematic',
                'subthematic',
                'projectHolders',
                'perimeters',
                'beneficiaries'
            ])->get();
        } else {
            $result = (new CallsForProjects())->get();
        }

        $separator = $this->getSeparator();

        return $result->map(function ($item) use ($separator) {
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
                empty($item->projectHolders) ? '' : implode($separator, $item->projectHolders->pluck('name')->all()),
                empty($item->perimeters) ? '' : implode($separator, $item->perimeters->pluck('name')->all()),
                $item->objectives,
                empty($item->beneficiaries) ? '' : implode($separator, $item->beneficiaries->pluck('name_complete')->all()),
                $item->beneficiary_comments,
                $item->allocation_amount,
                $alloc_text,
                $item->technical_relay,
                $item->project_holder_contact,
                $item->website_url,
                $this->withDates ? $item->created_at : null,
                $this->withDates ? $item->updated_at : null,
            ];
        });
    }

    protected function setColumns()
    {
        if (empty($columns = request()->get('columns'))) {
            return false;
        }

        if ($columns === 'key') {
            $this->columns = array_keys($this->columns);
        }
    }

    protected function setWithDates()
    {
        if (!is_null($withDates = request()->get('withDates'))) {
            $this->withDates = (boolean)$withDates;
        }

        if ($this->withDates) {
            $this->columns['createdAt'] = "Date de création de l'aide";
            $this->columns['updatedAt'] = "Date de dernière modification de l'aide";
        }
    }

    protected function getSeparator()
    {
        if (request()->get('sep') === 'pipe') {
            return '<|>';
        }

        return ', ';
    }
}
