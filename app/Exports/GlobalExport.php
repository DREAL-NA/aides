<?php

namespace App\Exports;


abstract class GlobalExport
{
    protected $columns = [
        'name' => 'Nom',
        'description' => 'Description',
        'created_at' => 'Date de création',
        'deleted_at' => 'Date de mise à jour',
    ];

    protected $filename = 'export';
}