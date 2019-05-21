<?php

/*
|--------------------------------------------------------------------------
| Bko Routes
|--------------------------------------------------------------------------
|
| Here is where you can register bko routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'bko.home', 'uses' => 'IndexController@index']);

Route::resource('thematic', 'ThematicController', ['as' => 'bko', 'except' => ['show']]);
Route::post('thematic/select2', ['as' => 'bko.thematic.select2', 'uses' => 'ThematicController@select2']);

Route::resource('subthematic', 'SubthematicController', [
    'as' => 'bko',
    'parameters' => ['subthematic' => 'thematic'],
    'except' => ['show']
]);

Route::post('subthematic/select2', ['as' => 'bko.subthematic.select2', 'uses' => 'SubthematicController@select2']);

Route::resource('porteur-dispositif', 'ProjectHolderController', [
    'as' => 'bko',
    'parameters' => ['porteur-dispositif' => 'project_holder'],
    'except' => ['show']
]);
Route::post('porteur-dispositif/select2', ['as' => 'bko.porteur-dispositif.select2', 'uses' => 'ProjectHolderController@select2']);

Route::resource('perimetre', 'PerimeterController', [
    'as' => 'bko',
    'parameters' => ['perimetre' => 'perimeter'],
    'except' => ['show']
]);
Route::post('perimetre/select2', ['as' => 'bko.perimetre.select2', 'uses' => 'PerimeterController@select2']);

Route::resource('beneficiaire', 'BeneficiaryController', [
    'as' => 'bko',
    'parameters' => ['beneficiaire' => 'beneficiary'],
    'except' => ['show']
]);
Route::post('beneficiaire/select2', ['as' => 'bko.beneficiaire.select2', 'uses' => 'BeneficiaryController@select2']);

//    Route::resource('structure', 'OrganizationTypeController',
//        ['as' => 'bko', 'parameters' => ['structure' => 'organizationType'], 'except' => ['show']]);
//    Route::post('structure/select2', ['as' => 'bko.structure.select2', 'uses' => 'OrganizationTypeController@select2']);


Route::resource('site', 'WebsiteController', ['as' => 'bko', 'parameters' => ['site' => 'website']]);

Route::get('appel-a-projet/clotures', ['as' => 'bko.call.indexClosed', 'uses' => 'CallForProjectsController@indexClosed']);
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

// Newsletter
Route::resource('newsletter/subscriber', 'NewsletterSubscriberController', ['as' => 'bko', 'except' => ['show', 'destroy']]);

Route::post('newsletter/subscriber/{subscriber}/subscribe', [
    'as' => 'bko.subscriber.subscribe',
    'uses' => 'NewsletterSubscriberController@subscribe'
]);
Route::post('newsletter/subscriber/{subscriber}/unsubscribe', [
    'as' => 'bko.subscriber.unsubscribe',
    'uses' => 'NewsletterSubscriberController@unsubscribe'
]);
