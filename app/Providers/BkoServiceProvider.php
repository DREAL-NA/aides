<?php

namespace App\Providers;

use App\CallForProjects;
use App\Observers\CallForProjectsObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class BkoServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {

		if(request()->getHttpHost() != config('app.bko_subdomain').'.'.config('app.domain')) {
			return false;
		}

		CallForProjects::observe(CallForProjectsObserver::class);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
