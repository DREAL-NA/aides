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

Route::group([ 'domain' => config('app.bko_subdomain').'.'.config('app.domain') ], function() {
	Auth::routes();
});

Route::group([ 'namespace' => 'Bko', 'domain' => config('app.bko_subdomain').'.'.config('app.domain'), 'middleware' => [ 'auth' ] ], function() {
	Route::get('/', [ 'as' => 'bko.home', 'uses' => 'IndexController@index' ]);

	Route::resource('thematic', 'ThematicController', [ 'as' => 'bko' ]);
	Route::resource('subthematic', 'SubthematicController', [ 'as' => 'bko', 'parameters' => [ 'subthematic' => 'thematic' ] ]);

	Route::resource('porteur-dispositif', 'ProjectHolderController', [ 'as' => 'bko', 'parameters' => [ 'porteur-dispositif' => 'project_holder' ] ]);
	Route::post('porteur-dispositif/select2', [ 'as' => 'bko.porteur-dispositif.select2', 'uses' => 'ProjectHolderController@select2' ]);

	Route::resource('perimetre', 'PerimeterController', [ 'as' => 'bko', 'parameters' => [ 'perimetre' => 'perimeter' ] ]);
	Route::post('perimetre/select2', [ 'as' => 'bko.perimetre.select2', 'uses' => 'PerimeterController@select2' ]);

	Route::resource('beneficiaire', 'BeneficiaryController', [ 'as' => 'bko', 'parameters' => [ 'beneficiaire' => 'beneficiary' ] ]);
	Route::post('beneficiaire/select2', [ 'as' => 'bko.beneficiaire.select2', 'uses' => 'BeneficiaryController@select2' ]);

	Route::get('appel-a-projet/clotures', [ 'as' => 'bko.call.indexClosed', 'uses' => 'CallForProjectsController@indexClosed' ]);
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
		'parameters' => [ 'appel-a-projet' => 'callForProjects' ]
	]);
});

//Route::get('/', [ 'as' => 'front.home', 'uses' => 'FrontController@index' ]);