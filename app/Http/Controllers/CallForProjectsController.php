<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use App\Perimeter;
use App\ProjectHolder;
use App\Resources\CallsForProjects;
use App\Thematic;
use Illuminate\Http\Request;

class CallForProjectsController extends Controller
{
    public function index($closed = false)
    {
        if ($closed !== false && $closed !== 'clotures') {
            abort(404);
        }

        $callsForProjectsResource = new CallsForProjects();

        $callsAreClosedOnes = $callsForProjectsResource->setClosed($closed);

        $callsForProjects = $callsForProjectsResource->paginate();

        $pagination_appends = $callsForProjectsResource->paginationAppends;

        $primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
        $subthematics = Thematic::sub()->orderBy('name', 'asc')->get();
        if (!empty($subthematics)) {
            $subthematics = $subthematics->groupBy('parent_id');
        }
        $perimeters = Perimeter::orderBy('name', 'asc')->get();
        $project_holders = ProjectHolder::orderBy('name', 'asc')->get();

        $paramsPerimeters = $callsForProjectsResource->parameters['perimeter'] ?? null;

        return view(
            'front.call-for-projects',
            compact(
                'callsForProjects',
                'primary_thematics',
                'subthematics',
                'perimeters',
                'project_holders',
                'pagination_appends',
                'callsAreClosedOnes',
                'paramsPerimeters'
            )
        );
    }

    public function unique($slug, Request $request)
    {
        $callForProjects = CallForProjects::with([
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->where('slug', $slug)->first();

        if (empty($callForProjects)) {
            abort(404);
        }

        return view('front.call-for-projects-unique', compact('callForProjects'));
    }
}
