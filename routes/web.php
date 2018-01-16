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