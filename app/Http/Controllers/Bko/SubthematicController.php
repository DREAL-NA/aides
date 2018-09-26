<?php

namespace App\Http\Controllers\Bko;

use App\Http\Controllers\Controller;
use App\Thematic;
use Illuminate\Http\Request;

class SubthematicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thematics = Thematic::sub()->with('parent')->get();
        $primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();

        return view('bko.subthematic.index', compact('thematics', 'primary_thematics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $thematic = new Thematic();

        return view('bko.subthematic.create', compact('thematic'));
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
        $thematic = new Thematic();

        $validatedData = $request->validate($thematic->rulesSubthematic());

        $thematic->fill($validatedData);
        $thematic->save();

        if ($request->ajax()) {
            return response()->json($thematic);
        }

        return redirect(route('bko.subthematic.edit', $thematic))->with('success', "La thématique a bien été ajoutée.");
    }

    /**
     * Display the specified resource.
     *
     * @param Thematic $thematic
     *
     * @return void
     */
    public function show(Thematic $thematic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Thematic $thematic
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Thematic $thematic)
    {
        return view('bko.subthematic.edit', compact('thematic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Thematic $thematic
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thematic $thematic)
    {
        $validatedData = $request->validate($thematic->rulesSubthematic());

        $thematic->fill($validatedData);
        $thematic->save();

        return redirect(route('bko.subthematic.edit', $thematic))->with('success',
            "La thématique a bien été modifiée.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Thematic $thematic
     *
     * @return void
     * @throws \Exception
     */
    public function destroy(Request $request, Thematic $thematic)
    {
        if (!$request->ajax()) {
            exit;
        }

        $success = $thematic->delete();

        if ($success == 1) {
            return response()->json('deleted');
        }

        return response()->json('error', 422);
    }

    public function select2(Request $request)
    {
        if (empty($request->get('parent_id'))) {
            return response()->json([
                'results' => []
            ]);
        }

        $query = Thematic::sub()->where('parent_id', $request->get('parent_id'))->orderBy('name', 'asc');

        if (!empty($request->q)) {
            $query = $query->where('name', 'like', '%' . $request->q . '%');
        }

        $data = $query->get();

        $data = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        });

        return response()->json(['results' => $data]);
    }
}
