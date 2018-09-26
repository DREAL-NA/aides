<?php

namespace App\Http\Controllers\Bko;

use App\Http\Controllers\Controller;
use App\Perimeter;
use Illuminate\Http\Request;

class PerimeterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perimeters = Perimeter::with('parents')->get();

        return view('bko.perimeter.index', compact('perimeters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $perimeter = new Perimeter();

        $parents = Perimeter::all();

        return view('bko.perimeter.create', compact('perimeter', 'parents'));
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
        $perimeter = new Perimeter();
        $validatedData = $request->validate($perimeter->rules());

        $parents = collect($validatedData)->get('parents');
        $validatedData = collect($validatedData)->except('parents')->toArray();

        $perimeter->fill($validatedData);
        $perimeter->save();

        // Add the parents
        if (!empty($parents)) {
            $perimeter->parents()->sync($parents);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response($perimeter, 201);
        } else {
            return redirect(route('bko.perimetre.edit', $perimeter))->with('success',
                "Le périmètre a bien été ajouté.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perimeter $perimeter
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Perimeter $perimeter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perimeter $perimeter
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Perimeter $perimeter)
    {
        $perimeter->load('parents');
        $parents = Perimeter::where('id', '!=', $perimeter->id)->get();

        return view('bko.perimeter.edit', compact('perimeter', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Perimeter $perimeter
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perimeter $perimeter)
    {
        $validatedData = $request->validate($perimeter->rules());

        $parents = collect($validatedData)->get('parents');
        $validatedData = collect($validatedData)->except('parents')->toArray();

        $perimeter->fill($validatedData);
        $perimeter->save();

        // Add the parents
        if (!empty($parents)) {
            $perimeter->parents()->sync($parents);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response($perimeter, 201);
        } else {
            return redirect(route('bko.perimetre.edit', $perimeter))->with('success',
                "Le périmètre a bien été modifié.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Perimeter $perimeter
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Perimeter $perimeter)
    {
        if (!$request->ajax()) {
            exit;
        }

        $success = $perimeter->delete();

        if ($success == 1) {
            return response()->json('deleted');
        }

        return response()->json('error', 422);
    }

    public function select2(Request $request)
    {
        if (!empty($request->q)) {
            $data = Perimeter::where('name', 'like', '%' . $request->q . '%')->orderBy('name', 'asc')->get();
        } else {
            $data = Perimeter::orderBy('name', 'asc')->get();
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
