<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller {

	protected $callsForProjects;
	protected $filename;

	public function __construct() {
		$date = date('YmdHis');
		$this->callsForProjects = CallForProjects::with([ 'thematic', 'subthematic', 'perimeters', 'beneficiaries', 'projectHolders' ])->opened()->get()->groupBy('thematic_id');
		$this->filename         = 'dispositifs_financiers_'.$date;
	}

	public function xlsx($type) {
		if(empty($type) || !in_array($type, [ 'xlsx', 'ods' ])) {
			$type = 'xlsx';
		}

		Excel::create($this->filename, function($excel) {
			foreach($this->callsForProjects as $thematic => $callsForProjects) {
				$thematic = $callsForProjects->first()->thematic;
				$callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');
				$excel->sheet(str_limit($thematic->name, 30, '.'), function($sheet) use ($callsForProjects, $callsOfTheWeek) {
					$sheet->loadView('exports.excel', [ 'callsForProjects' => $callsForProjects, 'callsOfTheWeek' => $callsOfTheWeek ]);
				});
			}
		})->export($type);
	}

	public function pdf() {
		$pdf = PDF::loadView('exports.pdf', [ 'callsForProjects' => $this->callsForProjects ])->setPaper('a4', 'landscape');

		return $pdf->download($this->filename.'.pdf');
	}
}
