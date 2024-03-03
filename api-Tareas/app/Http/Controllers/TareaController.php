<?php

namespace App\Http\Controllers;

use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tarea::all();

        return TareaResource::collection($tareas);
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
    public function store(Request $request):JsonResource
    {
        $tarea = new Tarea();
        $tarea->titulo = $request->titulo;
        $tarea->descripcion = $request->descripcion;
        $tarea->save();

        $etiquetas = $request->etiquetas;
        $tareaId = $tarea->id;
        $tarea->etiquetas()->attach($etiquetas, ['tareas_id' => $tareaId]);

        return new TareaResource($tarea);
    }

    /**
     * Display the specified resource.
     */
    public function show($idTarea)
    {
        $tarea = Tarea::find($idTarea);
        return new TareaResource($tarea);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idTarea)
    {
        $tareaUpdate = Tarea::find($idTarea);
        $tareaUpdate->titulo = $request->titulo;
        $tareaUpdate->descripcion = $request->descripcion;
        $tareaUpdate->etiquetas()->detach();
        $tareaUpdate->etiquetas()->attach($request->etiquetas);

        $tareaUpdate->save();

        return new TareaResource($tareaUpdate);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idTarea)
    {
        $tareaDestroy = Tarea::find($idTarea);
        $tareaDestroy->delete();

        return response()->json(['success' => true], 200);
    }
}
