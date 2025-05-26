<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateProveedoreRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\Proveedore;
use Exception;

class ProveedoreController extends Controller
{
      function __construct()
    {
        $this->middleware('permission:ver-proveedores|crear-proveedores|editar-proveedores|eliminar-proveedores',['only'=> ['index']]);
        $this->middleware('permission:crear-proveedores',['only'=> ['create', 'store']]);
        $this->middleware('permission:editar-proveedores', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-proveedores',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::with('persona.documento')->get();
        return view ('proveedore.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $documentos = Documento::all();
        return view ('proveedore.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
          try{
            DB::beginTransaction();
            $persona = Persona::create($request->validated());
            $persona->proveedore()->create([
                'persona_id' => $persona->id
            ]);


            DB::commit();
        }catch(Exception $e){
         
            DB::rollBack();
        }
         return redirect()->route('proveedores.index')->with('success', 'Proveedor agregado exitosamente');
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
        $documentos=Documento::all();
        return view('proveedore.edit', compact('proveedore', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedoreRequest $request, Proveedore $proveedore)
    {
        try {
            DB::beginTransaction();
            Persona::where('id', $proveedore->persona->id)
            ->update($request->validated());

            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
        }
        return redirect()->route('proveedores.index')->with('success', 'Proveedor editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $message = '';
        $proveedore = Persona::find($id);
        if ($proveedore->estado == 1) {
            Persona::where('id', $proveedore->id)
                ->update([
                    'estado' => 0
                ]);
            $message="Proveedor eliminado exitosamente";
        } else {
            Persona::where('id', $proveedore->id)
                ->update([
                    'estado' => 1
                ]);
                $message="Proveedor restaurado exitosamente";
        }

        return redirect()->route('proveedores.index')->with('success', $message);
    }
}
