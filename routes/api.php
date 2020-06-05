<?php

use App\Http\Controllers\AutocompletePerimeters;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/dispositifs/ouverts', function (Request $request) {
//    return \App\CallForProjects::with([
//        'thematic',
//        'subthematic',
//        'projectHolders',
//        'perimeters',
//        'beneficiaries'
//    ])->opened()->get();
//});
//
//Route::get('/dispositifs/clotures', function (Request $request) {
//    return \App\CallForProjects::with([
//        'thematic',
//        'subthematic',
//        'projectHolders',
//        'perimeters',
//        'beneficiaries'
//    ])->closed()->get();
//});

Route::get('/dispositifs/{type?}', function (Request $request) {
    $query = \App\CallForProjects::with([
        'thematic',
        'subthematic',
        'projectHolders',
        'perimeters',
        'beneficiaries'
    ]);

    if (!empty($request->type)) {
        if ($request->type == 'ouverts') {
            $query = $query->opened();
        } elseif ($request->type == 'clotures') {
            $query = $query->closed();
        } else {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }
    }

    return $query->get();
});

Route::get('/sites', function (Request $request) {
    return \App\Website::with(['perimeters'])->get();
});

Route::get('autocomplete/perimeters', 'AutocompletePerimeters@autocomplete')->middleware('throttle:200,1');
