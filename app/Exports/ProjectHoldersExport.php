<?php

namespace App\Exports;

use App\ProjectHolder;

class ProjectHoldersExport extends GlobalExport implements GlobalExportInterface
{
    protected $filename = 'porteurs_projets';

    public function collection()
    {
        return ProjectHolder::get(array_keys($this->columns))->sortBy('name');
    }

}