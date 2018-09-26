<?php

namespace App\Exports;

use App\Resources\CallsForProjects;

class DispositifsExport extends GlobalExport implements GlobalExportInterface
{
    protected $columns = [
        'Thématique',
        'Sous-thématique',
        'Intitulé',
        'Date de clôture',
        'Porteurs du dispositif',
        'Périmètres',
        'Objectifs',
        'Bénéficiaires',
        'Bénéficiaires : commentaires',
        'Dotation globale et / ou par projet',
        'Dotation : montant',
        'Dotation : commentaires',
        'Relais technique DREAL / DDTMs',
        'Contact(s) porteur de projet',
        'Lien vers le site'
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