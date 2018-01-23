<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use App\Perimeter;
use App\Thematic;
use Illuminate\Http\Request;

class FrontController extends Controller {

	public function home() {
		$countCallsForProjects = CallForProjects::opened()->count();
		$thematics = Thematic::orderBy('name', 'asc')->get();
		$perimeters = Perimeter::orderBy('name', 'asc')->get();

		return view('front.home', compact('countCallsForProjects', 'thematics', 'perimeters'));
	}

	public function contactPost(Request $request) {

	}
}
