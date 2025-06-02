<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateClienteRequuest;
use Illuminate\Http\Request;
use App\Models\Documento;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\Cliente;
use PhpParser\Node\Stmt\TryCatch;

class ClienteController extends Controller
{
     function __construct()
    {
        $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|eliminar-cliente',['only'=> ['index']]);
        $this->middleware('permission:crear-cliente',['only'=> ['create', 'store']]);
        $this->middleware('permission:editar-cliente', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-cliente',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('persona.documento')->get();
        
        return view('clientes.index',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('clientes.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        
        try{
            DB::beginTransaction();
            $persona = Persona::create($request->validated());
            $persona->cliente()->create([
                'persona_id' => $persona->id
            ]);


            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            
        }
    

        return redirect()->route('clientes.index')->with('success', 'Cliente agregado exitosamente');
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
    public function edit(Cliente $cliente)
    {
        $cliente->load('persona.documento');
        $documentos=Documento::all();
        return view('clientes.edit', compact('cliente', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequuest $request, Cliente $cliente)
    {
        try {
            DB::beginTransaction();
            Persona::where('id', $cliente->persona->id)
            ->update($request->validated());

            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
        }
        return redirect()->route('clientes.index')->with('success', 'Cliente editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $persona = Persona::find($id);
        if ($persona->estado == 1) {
            Persona::where('id', $persona->id)
                ->update([
                    'estado' => 0
                ]);
            $message="Cliente eliminado exitosamente";
        } else {
            Persona::where('id', $persona->id)
                ->update([
                    'estado' => 1
                ]);
                $message="Cliente restaurado exitosamente";
        }

        return redirect()->route('clientes.index')->with('success', $message);
    }
}
