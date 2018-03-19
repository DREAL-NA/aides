<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['domain' => config('app.bko_subdomain') . '.' . config('app.domain')], function () {
    Auth::routes();
});

Route::group([
    'namespace' => 'Bko',
    'domain' => config('app.bko_subdomain') . '.' . config('app.domain'),
    'middleware' => ['auth']
], function () {
    Route::get('/', ['as' => 'bko.home', 'uses' => 'IndexController@index']);

    Route::resource('thematic', 'ThematicController', ['as' => 'bko', 'except' => ['show']]);
    Route::resource('subthematic', 'SubthematicController',
        ['as' => 'bko', 'parameters' => ['subthematic' => 'thematic'], 'except' => ['show']]);

    Route::resource('porteur-dispositif', 'ProjectHolderController',
        ['as' => 'bko', 'parameters' => ['porteur-dispositif' => 'project_holder'], 'except' => ['show']]);
    Route::post('porteur-dispositif/select2',
        ['as' => 'bko.porteur-dispositif.select2', 'uses' => 'ProjectHolderController@select2']);

    Route::resource('perimetre', 'PerimeterController',
        ['as' => 'bko', 'parameters' => ['perimetre' => 'perimeter'], 'except' => ['show']]);
    Route::post('perimetre/select2', ['as' => 'bko.perimetre.select2', 'uses' => 'PerimeterController@select2']);

    Route::resource('beneficiaire', 'BeneficiaryController',
        ['as' => 'bko', 'parameters' => ['beneficiaire' => 'beneficiary'], 'except' => ['show']]);
    Route::post('beneficiaire/select2',
        ['as' => 'bko.beneficiaire.select2', 'uses' => 'BeneficiaryController@select2']);

    Route::resource('structure', 'OrganizationTypeController',
        ['as' => 'bko', 'parameters' => ['structure' => 'organizationType'], 'except' => ['show']]);
    Route::post('structure/select2', ['as' => 'bko.structure.select2', 'uses' => 'OrganizationTypeController@select2']);

    Route::resource('site', 'WebsiteController', ['as' => 'bko', 'parameters' => ['site' => 'website']]);

    Route::get('appel-a-projet/clotures',
        ['as' => 'bko.call.indexClosed', 'uses' => 'CallForProjectsController@indexClosed']);
    Route::resource('appel-a-projet', 'CallForProjectsController', [
        'names' => [
            'index' => 'bko.call.index',
            'create' => 'bko.call.create',
            'store' => 'bko.call.store',
            'show' => 'bko.call.show',
            'edit' => 'bko.call.edit',
            'update' => 'bko.call.update',
            'destroy' => 'bko.call.destroy',
        ],
        'parameters' => ['appel-a-projet' => 'callForProjects']
    ]);

    Route::get('appel-a-projet/{callForProjects}/dupliquer', ['as' => 'bko.call.duplicate', 'uses' => 'CallForProjectsController@duplicate']);

    Route::resource('utilisateur', 'UserController', ['as' => 'bko', 'parameters' => ['utilisateur' => 'user'], 'except' => ['show']])->middleware('admin');

    Route::get('profil', ['as' => 'bko.profile.edit', 'uses' => 'ProfileController@edit']);
    Route::post('profil', ['as' => 'bko.profile.update', 'uses' => 'ProfileController@update']);
    Route::post('profil/password', ['as' => 'bko.profile.password', 'uses' => 'ProfileController@updatePassword']);

});

Route::feeds();

Route::get('/', ['as' => 'front.home', 'uses' => 'FrontController@home']);

Route::post('/contact', ['as' => 'front.contact.store', 'uses' => 'FrontController@contactStore']);
Route::get('/contact', function () {
    return view('front.contact');
})->name('front.contact');

Route::get('/mentions-legales', function () {
    return view('front.legal-notice');
})->name('front.legal-notice');

Route::get('/accessibilite', function () {
    return view('front.accessibility');
})->name('front.accessibility');

Route::get('/qui-sommes-nous/projet', function () {
    return view('front.about-us.project');
})->name('front.about-us.project');

Route::get('/qui-sommes-nous/base-de-donnees', function () {
    return view('front.about-us.database');
})->name('front.about-us.database');

Route::get('/qui-sommes-nous/equipe', function () {
    return view('front.about-us.team');
})->name('front.about-us.team');

Route::get('/outils/mise-a-disposition-des-donnees', function () {
    return view('front.tools.data');
})->name('front.tools.data');

Route::get('/outils/sitotheque', ['as' => 'front.tools.website-library', 'uses' => 'FrontController@websites']);

Route::get('/dispositifs/{closed?}', ['as' => 'front.dispositifs', 'uses' => 'FrontController@callForProjects']);
Route::get('/dispositifs/detail/{slug}',
    ['as' => 'front.dispositifs.unique', 'uses' => 'FrontController@callForProjectsUnique']);

Route::get('recherche', ['as' => 'front.search', 'uses' => 'FrontController@search']);

// Exports
Route::get('export/{table}/csv', ['as' => 'bko.export.table', 'uses' => 'ExportController@table'])->middleware('auth');
Route::get('export/dispositifs/pdf', ['as' => 'export.pdf', 'uses' => 'ExportController@dispositifsPdf']);
Route::get('export/dispositifs/{type}', ['as' => 'export.xlsx', 'uses' => 'ExportController@dispositifsXlsx']);


Route::fallback(function () {
    return response()->view('errors.404', [], 404);
})->name('front.error');

if (app()->environment() != 'production') {
    Route::get('/search', function () {
//    $call = \App\CallForProjects::find(97);
//    dd($call->toSearchableArray());

        $data = App\CallForProjects::search('entreprise')->raw();

        dd($data);

        dd($data->pluck('id')->all());
    });

    Route::get('/model/{id}', function ($id) {
        $model = \App\CallForProjects::find($id);
        dd($model->toSearchableArray());
    });
}
