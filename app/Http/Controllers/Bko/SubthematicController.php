<?php

namespace App\Http\Controllers\Bko;

use App\Thematic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubthematicController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$thematics = Thematic::sub()->with('parent')->get();
		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();

		return view('bko.subthematic.index', compact('thematics', 'primary_thematics'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$thematic = new Thematic();
		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();


		return view('bko.subthematic.create', compact('thematic', 'primary_thematics'));
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

		$validatedData = $request->validate($thematic->rulesSubthematic());

		$thematic->fill($validatedData);
		$thematic->save();

		return redirect(route('bko.subthematic.edit', $thematic))->with('success', "La thématique a bien été ajoutée.");
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
		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();

		return view('bko.subthematic.edit', compact('thematic', 'primary_thematics'));
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
		$validatedData = $request->validate($thematic->rulesSubthematic());

		$thematic->fill($validatedData);
		$thematic->save();

		return redirect(route('bko.subthematic.edit', $thematic))->with('success', "La thématique a bien été modifiée.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Thematic $thematic
	 *
	 * @return void
	 */
	public function destroy(Thematic $thematic) {
		//
	}
}
