<?php

namespace App\Http\Controllers\Bko;

use App\Beneficiary;
use App\CallForProjects;
use App\Http\Controllers\Controller;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;
use Illuminate\Http\Request;

class CallForProjectsController extends Controller {
	/**
	 * Display a listing of the calls for projects opened.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$callsForProjects = CallForProjects::with([ 'thematic', 'projectHolders', 'perimeters', 'beneficiaries' ])->opened()->get();
		$callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');

//		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
//		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');

		$primary_thematics = $callsForProjects->map(function($item) {
			return $item->thematic;
		})->unique()->values();

		$perimeters = $callsForProjects->pluck('perimeters')->flatten();
		$project_holders = $callsForProjects->pluck('projectHolders')->flatten();

		$subthematics = CallForProjects::getRelationshipData(Thematic::class, $callsForProjects, 'subthematic_id');
		if(!empty($subthematics)) {
			$subthematics = $subthematics->groupBy('parent_id');
		}

		$title = "Liste des dispositifs financiers ouverts";

		return view('bko.callForProjects.index', compact('callsForProjects', 'primary_thematics', 'subthematics', 'project_holders', 'perimeters', 'title', 'callsOfTheWeek'));
	}

	/**
	 * Display a listing of the calls for projects closed.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexClosed() {
		$callsForProjects = CallForProjects::with([ 'thematic', 'projectHolders', 'perimeters', 'beneficiaries' ])->opened()->get();
		$callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');
//		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
//		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');

		$primary_thematics = $callsForProjects->map(function($item) {
			return $item->thematic;
		})->unique()->values();

		$perimeters = $callsForProjects->pluck('perimeters')->flatten();
		$project_holders = $callsForProjects->pluck('projectHolders')->flatten();
		$subthematics = CallForProjects::getRelationshipData(Thematic::class, $callsForProjects, 'subthematic_id');
		if(!empty($subthematics)) {
			$subthematics = $subthematics->groupBy('parent_id');
		}

		$title = "Liste des dispositifs financiers fermés";

		return view('bko.callForProjects.index', compact('callsForProjects', 'primary_thematics', 'subthematics', 'project_holders', 'perimeters', 'title', 'callsOfTheWeek'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$callForProjects = new CallForProjects();
		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');

		return view('bko.callForProjects.create', compact('callForProjects', 'primary_thematics', 'subthematics'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$callForProjects = new CallForProjects();

		$validatedData = $request->validate($callForProjects->rules());

		$callForProjects->fill(array_except($validatedData, [ 'perimeters', 'project_holders', 'beneficiaries' ]));
		$callForProjects->save();

		return redirect(route('bko.call.edit', $callForProjects))->with('success', "Le dispositif financier a bien été ajouté.");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\CallForProjects $callForProjects
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(CallForProjects $callForProjects) {
		return view('bko.callForProjects.show', compact('callForProjects'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\CallForProjects $callForProjects
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CallForProjects $callForProjects) {
		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');

		return view('bko.callForProjects.edit', compact('callForProjects', 'primary_thematics', 'subthematics'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\CallForProjects $callForProjects
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, CallForProjects $callForProjects) {
		$validatedData = $request->validate($callForProjects->rules());

		$callForProjects->fill(array_except($validatedData, [ 'perimeters', 'project_holders', 'beneficiaries' ]));
		$callForProjects->save();

		return redirect(route('bko.call.edit', $callForProjects))->with('success', "Le dispositif financier a bien été modifié.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param  \App\CallForProjects $callForProjects
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(Request $request, CallForProjects $callForProjects) {
		if(!$request->ajax()) {
			exit;
		}

		$success = $callForProjects->delete();

		if($success == 1) {
			return response()->json('deleted');
		}

		return response()->json('error', 422);
	}
}
