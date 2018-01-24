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

	public function callForProjects(Request $request) {
		$callsForProjects = CallForProjects::with([ 'thematic', 'subthematic', 'projectHolders', 'perimeters', 'beneficiaries' ])->opened()->get();

		$primary_thematics = $callsForProjects->map(function($item) {
			return $item->thematic;
		})->unique()->values();

		$perimeters = $callsForProjects->pluck('perimeters')->flatten()->unique('name')->sortBy('name');
		$project_holders = $callsForProjects->pluck('projectHolders')->flatten()->unique('name')->sortBy('name');

		$subthematics = CallForProjects::getRelationshipData(Thematic::class, $callsForProjects, 'subthematic_id');
		if(!empty($subthematics)) {
			$subthematics = $subthematics->groupBy('parent_id');
		}

		return view('front.call-for-projects', compact('callsForProjects', 'primary_thematics', 'subthematics', 'perimeters', 'project_holders'));
	}

	public function callForProjectsUnique($slug, Request $request) {
		$callForProjects = CallForProjects::with([ 'thematic', 'subthematic', 'projectHolders', 'perimeters', 'beneficiaries' ])->where('slug', $slug)->first();

		if(empty($callForProjects)) {
			abort(404);
		}

		return view('front.call-for-projects-unique', compact('callForProjects'));
	}

	public function contactPost(Request $request) {

	}
}
