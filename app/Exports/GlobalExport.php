<?php

namespace App\Exports;


use App\Export;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

abstract class GlobalExport
{
    protected $columns = [
        'id' => 'ID',
        'name' => 'Nom',
        'description' => 'Description',
        'created_at' => 'Date de création',
        'updated_at' => 'Date de mise à jour',
    ];

    protected $filename = 'export';

    public function collection()
    {
        return collect();
    }

    public function download($format = Writer::EXTENSION_CSV)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->fromArray(array_values($this->columns), null, 'A1');
        $spreadsheet->getActiveSheet()->fromArray($this->collection()->toArray(), null, 'A2');

        $export = new Writer($spreadsheet, $this->filename, $format);
        $export->download();
    }
}