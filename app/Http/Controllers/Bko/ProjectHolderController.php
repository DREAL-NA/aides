<?php

namespace App\Http\Controllers\Bko;

use App\ProjectHolder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectHolderController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$project_holder = new ProjectHolder();
		$validatedData = $request->validate($project_holder->rules());

		$project_holder->fill($validatedData);
		$project_holder->save();

		if($request->ajax()) {
			return response()->json($project_holder);
		} else {
			return redirect(route('bko.porteur-dispositif.edit', $thematic))->with('success', "Le porteur du dispositif a bien été ajouté.");
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ProjectHolder $projectHolder
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(ProjectHolder $projectHolder) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ProjectHolder $projectHolder
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(ProjectHolder $projectHolder) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\ProjectHolder $projectHolder
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, ProjectHolder $projectHolder) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ProjectHolder $projectHolder
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ProjectHolder $projectHolder) {
		//
	}

	public function select2(Request $request) {
		if(!empty($request->q)) {
			$data = ProjectHolder::where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->get();
		} else {
			$data = ProjectHolder::orderBy('name', 'asc')->get();
		}

		$data = $data->map(function($item) {
			return [
				'id' => $item->id,
				'text' => $item->name,
			];
		});

		return response()->json([ 'results' => $data ]);
	}
}
