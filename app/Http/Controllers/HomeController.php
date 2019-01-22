<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $countCallsForProjects = CallForProjects::opened()->count();
        $callsOfTheWeek = CallForProjects::with([
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->ofTheWeek()->orderBy('updated_at', 'desc')->get()->groupBy('thematic_id');

        $primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
        $perimeters = Perimeter::orderBy('name', 'asc')->get();
        $project_holders = ProjectHolder::orderBy('name', 'asc')->get();

        return view('front.home', compact('countCallsForProjects', 'primary_thematics', 'perimeters', 'callsOfTheWeek', 'project_holders'));
    }
}
