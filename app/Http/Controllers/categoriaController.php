<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoriaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|eliminar-categoria', ['only' => ['index'] ]);
        $this->middleware('permission:crear-categoria', ['only' => ['create', 'store'] ]);
        $this->middleware('permission:editar-categoria', ['only' => ['edit', 'update'] ]);
        $this->middleware('permission:eliminar-categoria', ['only' => ['destroy'] ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();
        // dd($categorias);
        return view('categoria.index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeCategoriaRequest $request)
    { 
        // dd($request);

        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('categorias.index')->with('success', 'Categoría registrada');
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
    public function edit(Categoria $categoria)
    {
        // dd($categoria);
        return view('categoria.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        Caracteristica::where('id', $categoria->caracteristica->id)->update($request->validated());

        return redirect()->route('categorias.index')->with('success','Categoría actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = '';
        $categoria = Categoria::find($id);
        
        if($categoria->caracteristica->estado == 1){
            Caracteristica::where('id', $categoria->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $mensaje = 'Categoría eliminada';
        }else{
            Caracteristica::where('id', $categoria->caracteristica->id)
            ->update([
                'estado' => 1
            ]);
            $mensaje = 'Categoría restaurada';
        }

        return redirect()->route('categorias.index')->with('success', $mensaje);
    }
}
