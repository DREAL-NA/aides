<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\CallForProjects;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller {

	protected $callsForProjects;
	protected $filename;

	public function __construct(Request $request) {
		$callsForProjects = CallForProjects::with([ 'thematic', 'subthematic', 'perimeters', 'beneficiaries', 'projectHolders' ])->orderBy('updated_at', 'desc')->opened();
		if(!empty($request->get(Thematic::URI_NAME_THEMATIC))) {
			$callsForProjects->whereIn('thematic_id', $request->get(Thematic::URI_NAME_THEMATIC));
		}
		if(!empty($request->get(Thematic::URI_NAME_SUBTHEMATIC))) {
			$callsForProjects->whereIn('subthematic_id', $request->get(Thematic::URI_NAME_SUBTHEMATIC));
		}
		if(!empty($request->get(ProjectHolder::URI_NAME))) {
			$callsForProjects->whereHas('projectHolders', function($query) use ($request) {
				$query->whereIn('project_holder_id', $request->get(ProjectHolder::URI_NAME));
			});
		}
		if(!empty($request->get(Perimeter::URI_NAME))) {
			$callsForProjects->whereHas('perimeters', function($query) use ($request) {
				$query->whereIn('perimeter_id', $request->get(Perimeter::URI_NAME));
			});
		}
		if(!empty($request->get(Beneficiary::URI_NAME))) {
			$callsForProjects->whereHas('beneficiaries', function($query) use ($request) {
				$query->whereIn('type', $request->get(Beneficiary::URI_NAME));
			});
		}
		$callsForProjects = $callsForProjects->get()->groupBy('thematic_id');
		$this->callsForProjects = $callsForProjects;

		$date = date('YmdHis');
		$this->filename         = 'dispositifs_financiers_'.$date;
	}

	public function xlsx($type) {
		if(empty($type) || !in_array($type, [ 'xlsx', 'ods' ])) {
			$type = 'xlsx';
		}

		sqdfghj
		Excel::create($this->filename, function($excel) {
			if($this->callsForProjects->isEmpty()) {
				$excel->sheet('Feuille 1', function($sheet) {
					$sheet->fromArray(['Aucune aide ne correspond à votre recherche. Veuillez modifier vos filtres.']);
				});
			} else {
				foreach($this->callsForProjects as $thematic => $callsForProjects) {
					$thematic = $callsForProjects->first()->thematic;
					$callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');
					$excel->sheet(str_limit($thematic->name, 30, '.'), function($sheet) use ($callsForProjects, $callsOfTheWeek) {
						$sheet->loadView('exports.excel', [ 'callsForProjects' => $callsForProjects, 'callsOfTheWeek' => $callsOfTheWeek, 'type' => 'xlsx' ]);

						// Fix for linking website
						$inc = 2;
						foreach($callsForProjects as $callsForProject) {
							$sheet->getCell('K'.$inc)->getHyperlink()->setUrl($callsForProject->website_url);
							$inc++;
						}
					});
				}
			}
		})->export($type);
	}

	public function pdf() {
		$pdf = PDF::loadView('exports.pdf', [ 'callsForProjects' => $this->callsForProjects, 'type' => 'pdf' ])->setPaper('a4', 'landscape');

		return $pdf->download($this->filename.'.pdf');
	}
}
