<?php

namespace App\Http\Controllers\Bko;

use App\ProjectHolder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectHolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectHolders = ProjectHolder::all();

        return view('bko.projectHolder.index', compact('projectHolders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectHolder = new ProjectHolder();

        return view('bko.projectHolder.create', compact('projectHolder'));
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
        $projectHolder = new ProjectHolder();
        $validatedData = $request->validate($projectHolder->rules());

        $projectHolder->fill($validatedData);
        $projectHolder->save();

        if ($request->ajax()) {
            return response()->json($projectHolder);
        } else {
            return redirect(route('bko.porteur-dispositif.edit', $projectHolder))->with('success',
                "Le porteur du dispositif a bien été ajouté.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProjectHolder $projectHolder
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectHolder $projectHolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectHolder $projectHolder
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectHolder $projectHolder)
    {
        return view('bko.projectHolder.edit', compact('projectHolder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ProjectHolder $projectHolder
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectHolder $projectHolder)
    {
        $validatedData = $request->validate($projectHolder->rules());

        $projectHolder->fill($validatedData);
        $projectHolder->save();

        if ($request->ajax()) {
            return response()->json($projectHolder);
        } else {
            return redirect(route('bko.porteur-dispositif.edit', $projectHolder))->with('success',
                "Le porteur du dispositif a bien été modifié.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\ProjectHolder $projectHolder
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, ProjectHolder $projectHolder)
    {
        if (!$request->ajax()) {
            exit;
        }

        $success = $projectHolder->delete();

        if ($success == 1) {
            return response()->json('deleted');
        }

        return response()->json('error', 422);
    }

    public function select2(Request $request)
    {
        if (!empty($request->q)) {
            $data = ProjectHolder::where('name', 'like', '%' . $request->q . '%')->orderBy('name', 'asc')->get();
        } else {
            $data = ProjectHolder::orderBy('name', 'asc')->get();
        }

        $data = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        });

        return response()->json(['results' => $data]);
    }
}
