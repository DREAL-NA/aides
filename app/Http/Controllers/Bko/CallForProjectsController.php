<?php

namespace App\Http\Controllers\Bko;

use App\CallForProjects;
use App\Http\Controllers\Controller;
use App\Thematic;
use Illuminate\Http\Request;

class CallForProjectsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('bko.subthematic.index');
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
		//
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
		//
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
		//
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
