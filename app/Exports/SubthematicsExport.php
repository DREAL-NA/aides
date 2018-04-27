<?php

namespace App\Exports;

use App\Thematic;

class SubthematicsExport extends GlobalExport implements GlobalExportInterface
{
    protected $filename = 'sous_thematiques';

    protected $columns = [
        'id' => 'ID',
        'parent_name' => 'Thématique',
        'name' => 'Nom de la sous-thématique',
        'description' => 'Description',
        'created_at' => 'Date de création',
        'updated_at' => 'Date de mise à jour',
    ];

    public function collection()
    {
        return Thematic::with('parent')->sub()->get()
            ->sortBy(function ($item) {
                return [$item->parent->name, $item->slug];
            })
            ->map(function ($item) {
                $item->parent_name = $item->parent->name;

                return $item->only(array_keys($this->columns));
            });
    }

}