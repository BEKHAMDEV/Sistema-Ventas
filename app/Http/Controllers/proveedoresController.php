<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateProveedorRequest;
use App\Models\Documento;
use App\Models\Persona;
use App\Models\Proveedore;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class proveedoresController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-proveedore|crear-proveedore|editar-proveedore|eliminar-proveedore', ['only' => ['index'] ]);
        $this->middleware('permission:crear-proveedore', ['only' => ['create', 'store'] ]);
        $this->middleware('permission:editar-proveedore', ['only' => ['edit', 'update'] ]);
        $this->middleware('permission:eliminar-proveedore', ['only' => ['destroy'] ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::with('persona.documento')->get();
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('proveedores.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        try {
            DB::beginTransaction();
            $persona = Persona::create($request->validated());
            $persona->proveedore()->create([
                'persona_id' => $persona->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success','Proveedor registrado');
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
    public function edit(Proveedore $proveedore)
    {
        $proveedore->load('persona.documento');
        $documentos = Documento::all();
        return view('proveedores.edit', compact('proveedore','documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedorRequest $request, Proveedore $proveedore)
    {
        try {
            DB::beginTransaction();
            Persona::where('id', $proveedore->persona->id)
            ->update($request->validated());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success','Proveedor actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = '';
        $persona = Persona::find($id);

        if($persona->estado == 1){
            Persona::where('id', $persona->id)
            ->update([
                'estado' => 0
            ]);
            $mensaje = 'Proveedor eliminado';
        }else{
            Persona::where('id', $persona->id)
            ->update([
                'estado' => 1
            ]);
            $mensaje = 'Proveedor restaurado';
        }

        return redirect()->route('proveedores.index')->with('success', $mensaje);
    }
}
