<?php

namespace App\Http\Controllers\Bko;

use App\OrganizationType;
use App\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$websites = Website::with('organizationType')->get();
		$organizationTypes = $websites->map(function($item) {
			return $item->organizationType;
		})->unique()->sortBy('name')->values();

		return view('bko.website.index', compact('websites', 'organizationTypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$website = new Website();

		return view('bko.website.create', compact('website'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$website = new Website();
		$validatedData = $request->validate($website->rules());

		if(!empty($validatedData['logo'])) {
			unset($validatedData['logo']);
		}
		$website->fill($validatedData);
		$website->save();

		if(!empty($request->file('logo'))) {
			$website->addLogo();
		}

		return redirect(route('bko.site.edit', $website))->with('success', "Le site de recensmeent a bien été ajouté.");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Website $website
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Website $website) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Website $website
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Website $website) {
		return view('bko.website.edit', compact('website'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Website $website
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Website $website) {
		$validatedData = $request->validate($website->rules());

		if(!empty($validatedData['logo'])) {
			unset($validatedData['logo']);
		}
		$website->fill($validatedData);
		$website->save();

		if(!empty($request->file('logo'))) {
			$website->addLogo();
		}

		return redirect(route('bko.site.edit', $website))->with('success', "Le site de recensmeent a bien été modifié.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Website $website
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Website $website) {
		//
	}
}
