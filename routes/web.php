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
});

Route::get('/', [ 'as' => 'front.home', 'uses' => 'FrontController@index' ]);