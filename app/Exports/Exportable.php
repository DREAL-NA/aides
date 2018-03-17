<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 17/03/2018
 * Time: 11:24
 */

namespace App\Exports;


use App\Export;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

trait Exportable
{

    public function collection()
    {
        return collect();
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->fromArray(array_values($this->columns), null, 'A1');
        $spreadsheet->getActiveSheet()->fromArray($this->collection()->toArray(), null, 'A2');

        $export = new Export($spreadsheet, $this->filename, Export::EXTENSION_CSV);
        $export->download();
    }
}