<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarcasRequest;
use App\Http\Requests\UpdateMarcasRequest;
use App\Models\Caracteristica;
use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class marcasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-marca|crear-marca|editar-marca|eliminar-marca', ['only' => ['index'] ]);
        $this->middleware('permission:crear-marca', ['only' => ['create', 'store'] ]);
        $this->middleware('permission:editar-marca', ['only' => ['edit', 'update'] ]);
        $this->middleware('permission:eliminar-marca', ['only' => ['destroy'] ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();

        return view('marcas.index', ['marcas' => $marcas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcasRequest $request)
    {
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->marca()->create([
                'caracteristica_id' => $caracteristica->id
            ]);

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('marcas.index')->with('success', 'Categoría registrada');
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
    public function edit(Marca $marca)
    {
        return view('marcas.edit', ['marca' => $marca]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcasRequest $request, Marca $marca)
    {
        Caracteristica::where('id', $marca->caracteristica->id)->update($request->validated());

        return redirect()->route('marcas.index')->with('success','Marca actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = '';
        $marca = Marca::find($id);
        
        if($marca->caracteristica->estado == 1){
            Caracteristica::where('id', $marca->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $mensaje = 'Marca eliminada';
        }else{
            Caracteristica::where('id', $marca->caracteristica->id)
            ->update([
                'estado' => 1
            ]);
            $mensaje = 'Marca restaurada';
        }

        return redirect()->route('marcas.index')->with('success', $mensaje);
    }
}
