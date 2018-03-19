<?php

namespace App\Exports;

use App\OrganizationType;

class OrganizationTypesExport extends GlobalExport implements GlobalExportInterface
{
    protected $filename = 'organisations';

    public function collection()
    {
        return OrganizationType::get(array_keys($this->columns))->sortBy('name');
    }

}