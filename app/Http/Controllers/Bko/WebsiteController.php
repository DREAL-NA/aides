<?php

namespace App\Http\Controllers\Bko;

use App\Http\Controllers\Controller;
use App\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::with(['perimeters', 'media'])->get();
//        $organizationTypes = $websites->map(function ($item) {
//            return $item->organizationType;
//        })->unique()->sortBy('name')->values();
        $perimeters = $websites->map(function ($item) {
            return $item->perimeters;
        })->flatten()->unique('id')->sortBy('name')->values();

        return view('bko.website.index', compact('websites', 'perimeters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function store(Request $request)
    {
        $website = new Website();
        $validatedData = $request->validate($website->rules());

        $perimeters = [];
        if (!empty($validatedData['logo'])) {
            unset($validatedData['logo']);
        }
        if (!empty($validatedData['perimeters'])) {
            $perimeters = $validatedData['perimeters'];
            unset($validatedData['perimeters']);
        }
        $website->fill($validatedData);
        $website->save();

        if (!empty($perimeters)) {
            $website->perimeters()->sync($perimeters);
        }

        if (!empty($request->file('logo'))) {
            $website->addLogo();
        }

        return redirect(route('bko.site.edit', $website))->with('success', "Le site de recensement a bien été ajouté.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Website $website
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        return view('bko.website.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Website $website
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Website $website)
    {
        $website->load('perimeters');

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
    public function update(Request $request, Website $website)
    {
        $validatedData = $request->validate($website->rules());

        $perimeters = [];
        if (!empty($validatedData['logo'])) {
            unset($validatedData['logo']);
        }
        if (!empty($validatedData['perimeters'])) {
            $perimeters = $validatedData['perimeters'];
            unset($validatedData['perimeters']);
        }
        $website->fill($validatedData);
        $website->save();

        $website->perimeters()->sync($perimeters);

        if (!empty($request->file('logo'))) {
            $website->addLogo();
        }

        return redirect(route('bko.site.edit', $website))->with('success',
            "Le site de recensement a bien été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Website $website
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Website $website)
    {
        if (!$request->ajax()) {
            exit;
        }

        $success = $website->delete();

        if ($success == 1) {
            return response()->json('deleted');
        }

        return response()->json('error', 422);
    }
}
