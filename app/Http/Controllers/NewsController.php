<?php

namespace App\Http\Controllers;

use App\CallForProjects;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function __invoke(Request $request)
    {
        $nbLastWeeks = 3;

        $startDate = Carbon::now()->startOfWeek()->subWeeks($nbLastWeeks);
        $endDate = Carbon::now()->endOfWeek()->subWeeks(1);

        if (!empty($start = $request->get('start')) && !empty($end = $request->get('end'))) {
            $startDate = Carbon::createFromFormat('Y-m-d', $start);
            $endDate = Carbon::createFromFormat('Y-m-d', $end);
        }

        $with = [
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ];

        $callsOfTheWeek = CallForProjects::with($with)
                                         ->ofTheWeek($startDate, $endDate)
                                         ->orderBy('updated_at', 'desc')
                                         ->get()
                                         ->groupBy('thematic_id');

        // Get the count if we want to get more previous news
        $beforeStartDate = $startDate->copy()->subWeeks($nbLastWeeks);
        $beforeEndDate = $startDate->copy()->subWeeks(1)->endOfWeek();

        $countPreviousWeeks = CallForProjects::query()
                                             ->ofTheWeek($beforeStartDate, $beforeEndDate)
                                             ->count();

        $dataToView = compact('callsOfTheWeek', 'startDate', 'endDate', 'beforeStartDate', 'beforeEndDate', 'countPreviousWeeks');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('front.news.weeks', $dataToView)->render()
            ], 200);
        }

        return view('front.news', $dataToView);
    }

    public function find(Request $request)
    {
        dd($request->get('start'), $request->get('end'));
    }
}
