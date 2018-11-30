<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use App\Exports\Writer;
use App\Resources\CallsForProjects;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportController extends Controller
{

    protected $callsForProjects;
    protected $filename;
    protected $thematics;

    public function __construct(Request $request)
    {
        ini_set('max_execution_time', 180); //3 minutes

        $callsForProjects = (new CallsForProjects())->get();

        $this->thematics = $callsForProjects->pluck('thematic', 'thematic_id')->sortBy('slug');

        $this->callsForProjects = $callsForProjects->groupBy('thematic_id');;

        $date = date('YmdHis');
        $this->filename = 'dispositifs_' . $date;
    }

    public function dispositifsXlsx()
    {
        // Before we allowed ODS file type, replaced by CSV
//        if (!in_array($type, ['xlsx', 'csv'])) {
//            abort(422);
//        }

        $type = 'xlsx';

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('DREAL Nouvelle-Aquitaine')
                    ->setLastModifiedBy('DREAL Nouvelle-Aquitaine')
                    ->setTitle('Liste des dispositifs')
                    ->setSubject('Dispositifs de soutien aux porteurs de projet en Nouvelle-Aquitaine')
                    ->setDescription('Liste des dispositifs de soutien aux porteurs de projet en Nouvelle-Aquitaine, fournie sous Licence Ouverte 2.0 par la DREAL Nouvelle-Aquitaine.');

        // Set the data
        $headerRow = [
            'Sous-thématique',
            'Intitulé',
            'Date de clôture',
            'Porteur du dispositif',
            'Périmètre',
            'Objectifs',
            'Bénéficiaires',
            'Dotation',
            'Relais technique DREAL / DDTMs',
            'Contact(s) porteur de projet',
            'Lien vers le site'
        ];

        foreach ($this->thematics as $thematic_id => $thematic) {
            if (empty($this->callsForProjects[$thematic->id])) {
                continue;
            }

            $callsForProjects = $this->callsForProjects[$thematic->id];
            $callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');

            // Create a new worksheet
            $worksheet = new Worksheet($spreadsheet, str_limit($thematic->name, 30, '.'));

            // Header
            $worksheet->fromArray($headerRow, null, 'A1');

            $letter = 'A';
            $number = 2;

            $rows_bck = [];

            foreach ($callsForProjects as $callsForProject) {
                $subthematic = is_null($callsForProject->subthematic) ? null : $callsForProject->subthematic;
                $allocations = [];
                if (!empty($callsForProject->allocation_global)) {
                    $allocations[] = 'Dotation globale';
                }
                if (!empty($callsForProject->allocation_per_project)) {
                    $allocations[] = 'Dotation par projet';
                }

                $alloc_text = implode("\n", $allocations);
                if (!empty($callsForProject->allocation_amount)) {
                    $alloc_text .= "\n\n" . $callsForProject->allocation_amount;
                }
                if (!empty($callsForProject->allocation_comments)) {
                    $alloc_text .= "\n" . $callsForProject->allocation_comments;
                }

                $worksheet->setCellValue($letter . $number, empty($subthematic) ? '' : $subthematic->name);
                $letter++;
                $worksheet->setCellValue($letter . $number, $callsForProject->name);
                $letter++;
                $worksheet->setCellValue($letter . $number,
                    empty($callsForProject->closing_date) ? '' : $callsForProject->closing_date->format('d/m/Y'));
                $letter++;
                $worksheet->setCellValue($letter . $number,
                    $callsForProject->projectHolders->pluck('name')->implode("\n"));
                $letter++;
                $worksheet->setCellValue($letter . $number, $callsForProject->perimeters->pluck('name')->implode("\n"));
                $letter++;
                $worksheet->setCellValue($letter . $number, $callsForProject->objectives);
                $letter++;
                $worksheet->setCellValue($letter . $number,
                    $callsForProject->beneficiaries->pluck('name_complete')->implode("\n") . "\n" . $callsForProject->beneficiary_comments);
                $letter++;
                $worksheet->setCellValue($letter . $number, $alloc_text);
                $letter++;
                $worksheet->setCellValue($letter . $number, $callsForProject->technical_relay);
                $letter++;
                $worksheet->setCellValue($letter . $number, $callsForProject->project_holder_contact);
                $letter++;
                $worksheet->setCellValue($letter . $number, $callsForProject->website_url);
                if (!empty($callsForProject->website_url)) {
                    $worksheet->getCell($letter . $number)->getHyperlink()->setUrl($callsForProject->website_url);
                }


                if (in_array($callsForProject->id, $callsOfTheWeek->toArray())) {
                    $rows_bck[] = 'A' . $number . ':K' . $number;
                }

                $number++;
                $letter = 'A';
            }

            // Column widths
            $worksheet->getColumnDimension('A')->setWidth(25);
            $worksheet->getColumnDimension('B')->setWidth(50);
            $worksheet->getColumnDimension('C')->setWidth(25);
            $worksheet->getColumnDimension('D')->setWidth(25);
            $worksheet->getColumnDimension('E')->setWidth(25);
            $worksheet->getColumnDimension('F')->setWidth(80);
            $worksheet->getColumnDimension('G')->setWidth(80);
            $worksheet->getColumnDimension('H')->setWidth(80);
            $worksheet->getColumnDimension('I')->setWidth(30);
            $worksheet->getColumnDimension('J')->setWidth(30);
            $worksheet->getColumnDimension('K')->setWidth(50);

            $spreadsheet->addSheet($worksheet);

            $worksheet->getStyle('A2:K' . $number)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
            $worksheet->getStyle('K2:K' . $number)->getFont()->getColor()->setARGB(Color::COLOR_BLUE);

            foreach ($rows_bck as $row) {
                $worksheet->getStyle($row)->getFill()
                          ->setFillType(Fill::FILL_SOLID)
                          ->getStartColor()->setRGB('5CDB95');
            }
        }

        $spreadsheet->removeSheetByIndex(0);

        // Download the file
        $export = new Writer($spreadsheet, $this->filename, $type);
        $export->download();

        die();
    }

    public function dispositifsPdf()
    {
        $pdf = PDF::loadView(
            'exports.pdf',
            ['thematics' => $this->thematics, 'callsForProjects' => $this->callsForProjects, 'type' => 'pdf']
        )
                  ->setPaper('a4', 'landscape');

        return $pdf->download($this->filename . '.pdf');
    }

    public function table($table)
    {
        if ($table !== 'dispositifs' && auth()->check() === false) {
            abort(404);
        }

        if (app()->environment() != 'production' && debugbar()->isEnabled()) {
            debugbar()->disable();
        }

        $namespace = "App\\Exports\\";

        $class = $namespace . studly_case($table) . 'Export';

        if (!class_exists($class)) {
            abort(404);
        }

        return (new $class)->download();
    }
}
