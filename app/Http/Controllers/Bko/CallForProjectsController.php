<?php

namespace App\Http\Controllers\Bko;

use App\CallForProjects;
use App\Http\Controllers\Controller;
use App\Perimeter;
use App\Thematic;
use Illuminate\Http\Request;

class CallForProjectsController extends Controller
{
    /**
     * Display a listing of the calls for projects opened.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $callsForProjects = CallForProjects::with([
            'thematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->opened()->get();
        $callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');

//		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
//		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');

        $primary_thematics = $callsForProjects->map(function ($item) {
            return $item->thematic;
        })->unique()->values()->sortBy('slug');

        $perimeters = $callsForProjects->pluck('perimeters')->flatten()->unique('name')->sortBy('name');
        $project_holders = $callsForProjects->pluck('projectHolders')->flatten()->unique('name')->sortBy('name');

        $subthematics = CallForProjects::getRelationshipData(Thematic::class, $callsForProjects, 'subthematic_id');
        if (!empty($subthematics)) {
            $subthematics = $subthematics->sortBy('slug')->groupBy('parent_id');
        }

        $title = "Liste des aides ouvertes";

        $closed = false;

        return view(
            'bko.callForProjects.index',
            compact('callsForProjects', 'primary_thematics', 'subthematics', 'project_holders', 'perimeters', 'title', 'callsOfTheWeek', 'closed')
        );
    }

    /**
     * Display a listing of the calls for projects closed.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexClosed()
    {
        $callsForProjects = CallForProjects::with([
            'thematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->closed()->get();
        $callsOfTheWeek = CallForProjects::filterCallsOfTheWeek($callsForProjects)->pluck('id');
//		$primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
//		$subthematics = Thematic::sub()->orderBy('name', 'asc')->get()->groupBy('parent_id');

        $primary_thematics = $callsForProjects->map(function ($item) {
            return $item->thematic;
        })->unique()->values();

        $perimeters = $callsForProjects->pluck('perimeters')->flatten()->unique('name')->sortBy('name');
        $project_holders = $callsForProjects->pluck('projectHolders')->flatten()->unique('name')->sortBy('name');

        $subthematics = CallForProjects::getRelationshipData(Thematic::class, $callsForProjects, 'subthematic_id');
        if (!empty($subthematics)) {
            $subthematics = $subthematics->groupBy('parent_id');
        }

        $title = "Liste des aides clôturées";

        $closed = true;

        return view(
            'bko.callForProjects.index',
            compact('callsForProjects', 'primary_thematics', 'subthematics', 'project_holders', 'perimeters', 'title', 'callsOfTheWeek', 'closed')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $callForProjects = new CallForProjects();
        $perimeters = Perimeter::all();

        return view('bko.callForProjects.create', compact('callForProjects', 'perimeters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $callForProjects = new CallForProjects();

        $validatedData = $request->validate($callForProjects->rules());

        if (!empty($validatedData['file'])) {
            unset($validatedData['file']);
        }

        $callForProjects->fill(array_except($validatedData, ['perimeters', 'project_holders', 'beneficiaries']));
        $callForProjects->save();

        if (!empty($request->file('file'))) {
            $callForProjects->addFiles();
        }

        return redirect(route('bko.call.edit', $callForProjects))
            ->with('success', "L'aide a bien été ajoutée.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CallForProjects $callForProjects
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CallForProjects $callForProjects)
    {
        return view('bko.callForProjects.show', compact('callForProjects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CallForProjects $callForProjects
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(CallForProjects $callForProjects)
    {
        $perimeters = Perimeter::all();

        return view('bko.callForProjects.edit', compact('callForProjects', 'perimeters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  \App\CallForProjects $callForProjects
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CallForProjects $callForProjects)
    {
        $validatedData = $request->validate($callForProjects->rules());

        if (!empty($validatedData['file'])) {
            unset($validatedData['file']);
        }

        $callForProjects->fill(array_except($validatedData, ['perimeters', 'project_holders', 'beneficiaries']));
        $callForProjects->save();

        if (!empty($request->file('file'))) {
            $callForProjects->addFiles();
        }

        return redirect(route('bko.call.edit', $callForProjects))
            ->with('success', "L'aide a bien été modifiée.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\CallForProjects $callForProjects
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, CallForProjects $callForProjects)
    {
        if (!$request->ajax()) {
            exit;
        }

        $success = $callForProjects->delete();

        if ($success == 1) {
            return response()->json('deleted');
        }

        return response()->json('error', 422);
    }

    /**
     * Duplicate a call for projects
     *
     * @param  \App\CallForProjects $callForProjects
     *
     * @return \Illuminate\Http\Response
     */
    public function duplicate(CallForProjects $callForProjects)
    {
        $callForProjects->load(['projectHolders', 'perimeters', 'beneficiaries']);

        $new = $callForProjects->replicate();

        // Change the name
//        $inc = 0;
//        $isUnique = false;
//        while ($isUnique === false) {
//            $name = $new->name . ' - Dupliqué' . ($inc > 0 ? " - {$inc}" : '');
//
//            if (is_null($tmp = CallForProjects::whereName($name)->first())) {
//                $isUnique = true;
//                $new->name = $name;
//
//                break;
//            }
//
//            $inc++;
//        }

        $new->push();

//         Saving relations
        foreach ($callForProjects->getRelations() as $relation => $entries) {
            $new->{$relation}()->saveMany($entries);
        }

        // Saving file
        if (!empty($file = $callForProjects->getFirstMedia($collection = CallForProjects::MEDIA_COLLECTION))) {
            $new->clearMediaCollection($collection);
            $new
                ->addMediaFromUrl($file->getUrl())
                ->toMediaCollection($collection);
        }

        return redirect(route('bko.call.edit', $new))
            ->with('success', "L'aide a bien été dupliquée.");
    }
}
