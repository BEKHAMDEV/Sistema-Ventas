<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresentacionesRequest;
use App\Http\Requests\UpdatePresentacionesRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class presentacionesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-presentacione|crear-presentacione|editar-presentacione|eliminar-presentacione', ['only' => ['index'] ]);
        $this->middleware('permission:crear-presentacione', ['only' => ['create', 'store'] ]);
        $this->middleware('permission:editar-presentacione', ['only' => ['edit', 'update'] ]);
        $this->middleware('permission:eliminar-presentacione', ['only' => ['destroy'] ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentaciones = Presentacione::with('caracteristica')->get();
        // dd($presentaciones);
        return view('presentaciones.index', ['presentaciones' => $presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacionesRequest $request)
    {
        // dd($request);

        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id
            ]);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }

        return redirect()->route('presentaciones.index')->with('success', 'Presentación registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presentacione $presentacione)
    {
        // dd($presentacione);
        return view('presentaciones.edit',['presentacione' => $presentacione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacionesRequest $request, Presentacione $presentacione)
    {
        Caracteristica::where('id', $presentacione->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success', 'Presentación editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = '';
        $presentacion = Presentacione::find($id);

        if($presentacion->caracteristica->estado == 1){
            Caracteristica::where('id', $presentacion->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $mensaje = 'Presentación eliminada';
        }else{
            Caracteristica::where('id', $presentacion->caracteristica->id)
            ->update([
                'estado' => 1
            ]);
            $mensaje = 'Presentación restaurada';
        }

        return redirect()->route('presentaciones.index')->with('success', $mensaje);
    }
}
