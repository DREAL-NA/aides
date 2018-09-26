<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $query = empty($request->get('query')) ? '' : $request->get('query');

        $callsForProjects = CallForProjects::search($query)->paginate(config('app.pagination.perPage'));

        $callsForProjects->load(['thematic', 'subthematic', 'projectHolders', 'beneficiaries', 'perimeters']);

        return view('front.search', compact('query', 'callsForProjects'));
    }
}
