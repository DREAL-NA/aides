<?php

namespace App\Exports;

use App\Resources\CallsForProjects;

class DispositifsExport extends GlobalExport implements GlobalExportInterface
{
    protected $columns = [
        // These names are chosen to ease reuse and match existing similar datasets.
        // See https://www.ademe.fr/sites/default/files/assets/documents/aides_financieres_-_description_du_jeu_de_donnees_.pdf and https://github.com/MTES-MCT/aides-territoires/blob/9dd1ba9dcd076a6406c6684bbd907a04ad8f22d7/src/aids/models.py
        'thematique',
        'sousThematique',
        'titre',
        'dateCloture',  // ISO format used for dates in ADEME dataset
        'nomAttribuant',  // used in ADEME dataset
        'perimetres',
        'objet',  // used in ADEME dataset
        'publicsBeneficiaires',
        'publicsBeneficiairesDetails',
        'dotationEtendue',
        'dotationMontant',
        'dotationDetails',
        'contactDREALDDTMs',
        'contactAttribuant',
        'URL'
    ];

    protected function filename()
    {
        return 'dispositifs_' . date('YmdHis');
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

            return [
                $item->thematic->name,
                empty($item->subthematic) ? '' : $item->subthematic->name,
                $item->name,
                empty($item->closing_date) ? '' : $item->closing_date->format('d/m/Y'),
                empty($item->project_holders) ? '' : implode(', ', $item->project_holders->pluck('name')->all()),
                empty($item->perimeters) ? '' : implode(', ', $item->perimeters->pluck('name')->all()),
                $item->objectives,
                empty($item->beneficiaries) ? '' : implode(', ', $item->beneficiaries->pluck('name_complete')->all()),
                $item->beneficiary_comments,
                implode(', ', $allocations),
                $item->allocation_amount,
                $item->allocation_comments,
                $item->technical_relay,
                $item->project_holder_contact,
                $item->website_url,
            ];
        });
    }
}
