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
		$callsForProjects = CallForProjects::with(['subthematic.parent', 'projectHolder', 'perimeter', 'beneficiary'])->opened()->get();
		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');
//		$project_holders = ProjectHolder::orderBy('name', 'asc')->get();
//		$perimeters = Perimeter::orderBy('name', 'asc')->get();
//		$beneficiaries = Beneficiary::orderBy('name', 'asc')->get();

		$project_holders = $callsForProjects->map(function($item) {
			return $item->projectHolder;
		})->unique()->sortBy('name')->values();
		$perimeters = $callsForProjects->map(function($item) {
			return $item->perimeter;
		})->unique()->sortBy('name')->values();
		$beneficiaries = $callsForProjects->map(function($item) {
			return $item->beneficiary;
		})->unique()->sortBy('name')->values();

		$title = "Liste des appels à projets ouverts";

		return view('bko.callForProjects.index', compact('callsForProjects', 'primary_thematics', 'subthematics', 'project_holders', 'perimeters', 'beneficiaries', 'title'));
	}

	/**
	 * Display a listing of the calls for projects closed.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexClosed() {
		$callsForProjects = CallForProjects::with(['subthematic.parent', 'projectHolder', 'perimeter', 'beneficiary'])->closed()->get();
		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');
//		$project_holders = ProjectHolder::orderBy('name', 'asc')->get();
//		$perimeters = Perimeter::orderBy('name', 'asc')->get();
//		$beneficiaries = Beneficiary::orderBy('name', 'asc')->get();

		$project_holders = $callsForProjects->map(function($item) {
			return $item->projectHolder;
		})->unique()->sortBy('name')->values();
		$perimeters = $callsForProjects->map(function($item) {
			return $item->perimeter;
		})->unique()->sortBy('name')->values();
		$beneficiaries = $callsForProjects->map(function($item) {
			return $item->beneficiary;
		})->unique()->sortBy('name')->values();

		$title = "Liste des appels à projets fermés";

		return view('bko.callForProjects.index', compact('callsForProjects', 'primary_thematics', 'subthematics', 'project_holders', 'perimeters', 'beneficiaries', 'title'));
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

		$callForProjects->fill($validatedData);
		$callForProjects->save();

		return redirect(route('bko.call.edit', $callForProjects))->with('success', "L'appel à projets a bien été ajouté.");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\CallForProjects $callForProjects
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(CallForProjects $callForProjects) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\CallForProjects $callForProjects
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CallForProjects $callForProjects) {
		$callForProjects->load('subthematic');
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

		$callForProjects->fill($validatedData);
		$callForProjects->save();

		return redirect(route('bko.call.edit', $callForProjects))->with('success', "L'appel à projets a bien été modifié.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\CallForProjects $callForProjects
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(CallForProjects $callForProjects) {
		//
	}
}
