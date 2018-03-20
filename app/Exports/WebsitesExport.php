<?php

namespace App\Exports;

use App\Website;

class WebsitesExport extends GlobalExport implements GlobalExportInterface
{
    protected $columns = [
        'id' => 'ID',
//        'organization_type_name' => 'Organisation',
        'name' => 'Nom de la structure',
        'themes' => 'Thèmes',
        'perimeters' => 'Périmètres',
        'perimeter_comments' => 'Périmètres - Précisions',
        'delay' => 'Délai',
        'allocated_budget' => 'Budget alloué',
        'beneficiaries' => 'Bénéficiaires',
        'website_url' => 'Adresse internet',
        'description' => 'Observations',
        'created_at' => 'Date de création',
        'updated_at' => 'Date de mise à jour',
    ];

    protected $filename = 'sites';

    public function collection()
    {
        return Website::with(['perimeters'])->get()
            ->sortBy(function ($item) {
//                return [$item->organization_type_name, $item->name];
                return [$item->name];
            })
            ->map(function ($item) {
//                $item->organization_type_name = $item->organizationType->name;
                $item->perimeters = $item->perimeters->pluck('name')->implode(', ');

                return $item->only(array_keys($this->columns));
            });
    }

}