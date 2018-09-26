<?php

namespace App\Http\Controllers;

use App\Website;

class WebsitesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $websites = Website::with(['perimeters'])->orderBy('name')->paginate(config('app.pagination.perPage'));

        return view('front.tools.website-library', compact('websites'));
    }
}
