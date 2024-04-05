<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class roleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-role|crear-role|editar-role|eliminar-role', ['only' => ['index'] ]);
        $this->middleware('permission:crear-role', ['only' => ['create', 'store'] ]);
        $this->middleware('permission:editar-role', ['only' => ['edit', 'update'] ]);
        $this->middleware('permission:eliminar-role', ['only' => ['destroy'] ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('role.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Crear Rol
            $role = Role::create(['name' => $request->name]);

            // Convertir en entero el array 'permission'
            $data = array();
            foreach ($request->permission as $key => $item){
                $data[$key] = (int)$item;
            }

            // Asignar permisos
            if (!empty($data)){
                $role->syncPermissions($data);
            }

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rol registrado');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('success', 'Error al asignar rol');
        }

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
    public function edit(Role $role)
    {
        $permisos = Permission::all();
        return view('role.edit', compact('role','permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'permission' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar Rol
            Role::where('id', $role->id)
            ->update([
                'name' => $request->name
            ]);

            // Convertir en entero el array 'permission'
            $data = array();
            foreach ($request->permission as $key => $item){
                $data[$key] = (int)$item;
            }

            // Actualizar permisos
            if (!empty($data)){
                $role->syncPermissions($data);
            }

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rol actualizado');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('success', 'Error al actualizar rol');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado');
    }
}
