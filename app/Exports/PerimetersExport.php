<?php

namespace App\Exports;

use App\Perimeter;

class PerimetersExport extends GlobalExport implements GlobalExportInterface
{
    protected $filename = 'perimeters';

    protected $columns = [
        'id' => 'ID',
        'name' => 'Nom',
        'description' => 'Description',
        'created_at' => 'Date de création',
        'updated_at' => 'Date de mise à jour',
        'parents' => 'Parents associés',
    ];

    public function collection()
    {
        $perimeters = Perimeter::with('parents')->get(collect($this->columns)->except('parents')->keys()->toArray())->sortBy('name');

        return $perimeters->map(function ($item) {
            return collect($item->getAttributes())->put('parents', $item->parents->pluck('name')->implode(', '));
        });
    }

}