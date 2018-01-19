<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use Illuminate\Http\Request;

class FrontController extends Controller {

	public function home() {
		$countCallsForProjects = CallForProjects::opened()->count();

		return view('front.home', compact('countCallsForProjects'));
	}

}
