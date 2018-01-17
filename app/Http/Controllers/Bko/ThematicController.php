<?php

namespace App\Http\Controllers\Bko;

use App\Thematic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThematicController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$thematics = Thematic::primary()->get();

		return view('bko.thematic.index', compact('thematics'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$thematic = new Thematic();

		return view('bko.thematic.create', compact('thematic'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$thematic = new Thematic();

		$validatedData = $request->validate($thematic->rules());

		$thematic->fill($validatedData);
		$thematic->save();

		return redirect(route('bko.thematic.edit', $thematic))->with('success', "La thématique a bien été ajoutée.");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Thematic $thematic
	 *
	 * @return void
	 */
	public function show(Thematic $thematic) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Thematic $thematic
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Thematic $thematic) {
		return view('bko.thematic.edit', compact('thematic'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Thematic $thematic
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Thematic $thematic) {
		$validatedData = $request->validate($thematic->rules());

		$thematic->fill($validatedData);
		$thematic->save();

		return redirect(route('bko.thematic.edit', $thematic))->with('success', "La thématique a bien été modifiée.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param Thematic $thematic
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function destroy(Request $request, Thematic $thematic) {
		if(!$request->ajax()) {
			exit;
		}

		$success = $thematic->delete();

		if($success == 1) {
			return response()->json('deleted');
		}

		return response()->json('error', 422);
	}
}
