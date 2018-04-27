<?php

namespace App\Exports;

use App\Thematic;

class ThematicsExport extends GlobalExport implements GlobalExportInterface
{
    protected $filename = 'thematiques';

    public function collection()
    {
        return Thematic::primary()->get(array_keys($this->columns))->sortBy('slug')->makeHidden('slug');
    }

}