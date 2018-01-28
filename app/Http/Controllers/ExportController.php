<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\CallForProjects;
use App\Helpers\Date;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;
use Barryvdh\DomPDF\Facade as PDF;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    protected $callsForProjects;
    protected $filename;

    public function __construct(Request $request)
    {
        $callsForProjects = CallForProjects::with([
            'thematic',
            'subthematic',
            'perimeters',
            'beneficiaries',
            'projectHolders'
        ])->orderBy('updated_at', 'desc')->opened();
        if (!empty($request->get(Thematic::URI_NAME_THEMATIC))) {
            $callsForProjects->whereIn('thematic_id', $request->get(Thematic::URI_NAME_THEMATIC));
        }
        if (!empty($request->get(Thematic::URI_NAME_SUBTHEMATIC))) {
            $callsForProjects->whereIn('subthematic_id', $request->get(Thematic::URI_NAME_SUBTHEMATIC));
        }
        if (!empty($request->get(ProjectHolder::URI_NAME))) {
            $callsForProjects->whereHas('projectHolders', function ($query) use ($request) {
                $query->whereIn('project_holder_id', $request->get(ProjectHolder::URI_NAME));
            });
        }
        if (!empty($request->get(Perimeter::URI_NAME))) {
            $callsForProjects->whereHas('perimeters', function ($query) use ($request) {
                $query->whereIn('perimeter_id', $request->get(Perimeter::URI_NAME));
            });
        }
        if (!empty($request->get(Beneficiary::URI_NAME))) {
            $callsForProjects->whereHas('beneficiaries', function ($query) use ($request) {
                $query->whereIn('type', $request->get(Beneficiary::URI_NAME));
            });
        }
        if (!empty($request->get('date_null')) && $request->get('date_null') == 1) {
            $callsForProjects->closingDateNull();
        } elseif (!empty($request->get('date')) && Date::isValid($request->get('date'))) {
            $callsForProjects->closingDateAfter($request->get('date'));
        }
        $callsForProjects = $callsForProjects->get()->groupBy('thematic_id');
        $this->callsForProjects = $callsForProjects;

        $date = date('YmdHis');
        $this->filename = 'dispositifs_financiers_' . $date;
    }

    public function xlsx($type)
    {
        if (empty($type) || !in_array($type, ['xlsx', 'ods'])) {
            $type = 'xlsx';
        }

        Excel::create($this->filename, function ($excel) {
            if ($this->callsForProjects->isEmpty()) {
                $excel->sheet('Feuille 1', function ($sheet) {
                    $sheet->fromArray(['Aucune aide ne correspond à votre recherche. Veuillez modifier vos filtres.']);
                });
            } else {
                foreach ($this->callsForProjects as $thematic => $callsForProjects) {
                    $thematic = $callsForProjects->first()->thematic;
                    $callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');
                    $excel->sheet(str_limit($thematic->name, 30, '.'),
                        function ($sheet) use ($callsForProjects, $callsOfTheWeek) {
                            $sheet->loadView('exports.excel', [
                                'callsForProjects' => $callsForProjects,
                                'callsOfTheWeek' => $callsOfTheWeek,
                                'type' => 'xlsx'
                            ]);

                            // Fix for linking website
                            $inc = 2;
                            foreach ($callsForProjects as $callsForProject) {
                                $sheet->getCell('K' . $inc)->getHyperlink()->setUrl($callsForProject->website_url);
                                $inc++;
                            }
                        });
                }
            }
        })->export($type);
    }

    public function pdf()
    {
        $pdf = PDF::loadView('exports.pdf',
            ['callsForProjects' => $this->callsForProjects, 'type' => 'pdf'])->setPaper('a4', 'landscape');

        return $pdf->download($this->filename . '.pdf');
    }

    public function ods()
    {
        if (config('app.debug') == true) {
            \Debugbar::disable();
        }
        $writer = WriterFactory::create(Type::ODS);
        $writer->setShouldCreateNewSheetsAutomatically(true); // default value
        $writer->openToBrowser($this->filename . '.ods');

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
        $styleHeader = (new StyleBuilder())->setFontBold()->build();

//		$rowColWidth = [
//			'<col min="1" max="1" width="25" customWidth="1"/>',
//			'<col min="2" max="2" width="35" customWidth="1"/>',
//			'<col min="4" max="4" width="45" customWidth="1"/>',
//			'<col min="5" max="5" width="55" customWidth="1"/>',
//			'<col min="6" max="6" width="65" customWidth="1"/>',
//			'<col min="7" max="7" width="75" customWidth="1"/>',
//			'<col min="8" max="8" width="85" customWidth="1"/>',
//			'<col min="9" max="9" width="95" customWidth="1"/>',
//			'<col min="10" max="10" width="105" customWidth="1"/>',
//			'<col min="11" max="11" width="115" customWidth="1"/>',
//		];

        $styleRowInit = (new StyleBuilder())
            ->setShouldWrapText();
//						->setBackgroundColor(Color::YELLOW)


        if ($this->callsForProjects->isEmpty()) {
            $writer->addRow(['Aucune aide ne correspond à votre recherche. Veuillez modifier vos filtres.']);
        } else {
            $inc = 1;
            foreach ($this->callsForProjects as $thematic => $callsForProjects) {
                $thematic = $callsForProjects->first()->thematic;
                $callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');

                if ($inc == 1) {
                    $sheet = $writer->getCurrentSheet();
                } else {
                    $sheet = $writer->addNewSheetAndMakeItCurrent();
                }
                $sheet->setName(str_limit($thematic->name, 30, '.'));
                $writer->addRowWithStyle($headerRow, $styleHeader);

                foreach ($callsForProjects as $callsForProject) {
                    $subthematic = empty($callsForProject->subthematic_id) ? null : $callsForProject->subthematic;
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

                    $styleRow = $styleRowInit;
                    $styleRow = in_array($callsForProject->id,
                        $callsOfTheWeek->toArray()) ? $styleRow->setBackgroundColor('5CDB95') : $styleRow;
                    $styleRow = $styleRow->build();

                    $row = [
                        empty($subthematic) ? '' : $subthematic->name,
                        $callsForProject->name,
                        empty($callsForProject->closing_date) ? '' : $callsForProject->closing_date->format('d/m/Y'),
                        $callsForProject->projectHolders->pluck('name')->implode("\n"),
                        $callsForProject->perimeters->pluck('name')->implode("\n"),
                        $callsForProject->objectives,
                        $callsForProject->beneficiaries->pluck('name_complete')->implode("\n") . "\n" . $callsForProject->beneficiary_comments,
                        $alloc_text,
                        $callsForProject->technical_relay,
                        $callsForProject->project_holder_contact,
                        $callsForProject->website_url,
                    ];
                    $writer->addRowWithStyle($row, $styleRow);
                }

//				$writer->addRow($rowColWidth);

                $inc++;
            }
        }

        $writer->close();
    }
}
