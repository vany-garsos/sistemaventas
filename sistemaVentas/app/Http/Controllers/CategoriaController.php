<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use Exception;
use Illuminate\Contracts\Cache\Store;
use App\Models\Caracteristica;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categoria.index');
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
    public function store(StoreCategoriaRequest $request)
    {
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
           
            return redirect()->route('categorias.index')->with('success', 'categoria registrada exitosamente');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
