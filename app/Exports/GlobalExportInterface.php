<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 17/03/2018
 * Time: 11:21
 */

namespace App\Exports;


interface GlobalExportInterface
{
    public function collection();

    public function download();
}