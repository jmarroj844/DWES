<?php

namespace App\Http\Controllers;

use App\Http\Requests\EtiquetaRequest;
use App\Http\Resources\EtiquetaResource;
use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EtiquetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etiquetas = Etiqueta::all();

        return EtiquetaResource::collection($etiquetas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $etiquetaStore = new Etiqueta();
        $etiquetaStore->nombre = $request->nombre;
        $etiquetaStore->save();

        $tareas = $request->tareas;
        $etiquetaId = $etiquetaStore->id;
        $etiquetaStore->tareas()->attach($tareas, ['etiquetas_id' => $etiquetaId]);

        return new EtiquetaResource($etiquetaStore);
    }

    /**
     * Display the specified resource.
     */
    public function show($idEtiqueta)
    {
        $etiquetaShow = Etiqueta::find($idEtiqueta);

        return new EtiquetaResource($etiquetaShow);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etiqueta $etiqueta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idEtiqueta)
    {
        $etiquetaUpdate = Etiqueta::find($idEtiqueta);
        $etiquetaUpdate->nombre = $request->nombre;

        $etiquetaUpdate->tareas()->detach();
        $etiquetaUpdate->tareas()->attach($request->tareas);

        $etiquetaUpdate->save();

        return new EtiquetaResource($etiquetaUpdate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idEtiqueta)
    {
        $etiquetaDestroy = Etiqueta::find($idEtiqueta);
        $etiquetaDestroy->delete();
        return response()->json(['success' => true], 200);
    }
}
