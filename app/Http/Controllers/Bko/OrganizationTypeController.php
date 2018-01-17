<?php

namespace App\Http\Controllers\Bko;

use App\OrganizationType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganizationTypeController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$organizationTypes = OrganizationType::all();

		return view('bko.organizationType.index', compact('organizationTypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$organizationType = new OrganizationType();

		return view('bko.organizationType.create', compact('organizationType'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$organizationType = new OrganizationType();

		$validatedData = $request->validate($organizationType->rules());

		$organizationType->fill($validatedData);
		$organizationType->save();

		if($request->ajax()) {
			return response()->json($organizationType);
		} else {
			return redirect(route('bko.structure.edit', $organizationType))->with('success', "La structure a bien été ajoutée.");
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\OrganizationType $organizationType
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(OrganizationType $organizationType) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\OrganizationType $organizationType
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(OrganizationType $organizationType) {
		return view('bko.organizationType.edit', compact('organizationType'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\OrganizationType $organizationType
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, OrganizationType $organizationType) {
		$validatedData = $request->validate($organizationType->rules());

		$organizationType->fill($validatedData);
		$organizationType->save();

		return redirect(route('bko.structure.edit', $organizationType))->with('success', "La structure a bien été ajoutée.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param  \App\OrganizationType $organizationType
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(Request $request, OrganizationType $organizationType) {
		if(!$request->ajax()) {
			exit;
		}

		$success = $organizationType->delete();

		if($success == 1) {
			return response()->json('deleted');
		}

		return response()->json('error', 422);
	}

	public function select2(Request $request) {
		if(!empty($request->q)) {
			$data = OrganizationType::where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->get();
		} else {
			$data = OrganizationType::orderBy('name', 'asc')->get();
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
