<?php

namespace App\Http\Controllers\Bko;

use App\Beneficiary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeneficiaryController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$beneficiaries = Beneficiary::all();
		$types = Beneficiary::types();

		return view('bko.beneficiary.index', compact('beneficiaries', 'types'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$beneficiary = new Beneficiary();

		return view('bko.beneficiary.create', compact('beneficiary'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$beneficiary = new Beneficiary();
		$validatedData = $request->validate($beneficiary->rules());

		$beneficiary->fill($validatedData);
		$beneficiary->save();

		if($request->ajax()) {
			return response()->json($beneficiary);
		} else {
			return redirect(route('bko.beneficiaire.edit', $beneficiary))->with('success', "Le bénéficiaire a bien été ajouté.");
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Beneficiary $beneficiary
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Beneficiary $beneficiary) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Beneficiary $beneficiary
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Beneficiary $beneficiary) {
		return view('bko.beneficiary.edit', compact('beneficiary'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Beneficiary $beneficiary
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Beneficiary $beneficiary) {
		$validatedData = $request->validate($beneficiary->rules());

		$beneficiary->fill($validatedData);
		$beneficiary->save();

		if($request->ajax()) {
			return response()->json($beneficiary);
		} else {
			return redirect(route('bko.beneficiaire.edit', $beneficiary))->with('success', "Le bénéficiaire a bien été modifié.");
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param  \App\Beneficiary $beneficiary
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(Request $request, Beneficiary $beneficiary) {
		if(!$request->ajax()) {
			exit;
		}

		$success = $beneficiary->delete();

		if($success == 1) {
			return response()->json('deleted');
		}

		return response()->json('error', 422);
	}

	public function select2(Request $request) {
		if(!empty($request->q)) {
			$data = Beneficiary::where('name', 'like', '%'.$request->q.'%')->orderBy('name', 'asc')->get();
		} else {
			$data = Beneficiary::orderBy('name', 'asc')->get();
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
