<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Arr;

class userController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-user|crear-user|editar-user|eliminar-user',['only'=> ['index']]);
        $this->middleware('permission:crear-user',['only'=> ['create', 'store']]);
        $this->middleware('permission:editar-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-user',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            //encriptar contraseña
            $fieldhash = Hash::make($request->password);

            //Modificar el valor de password en el request
            $request->merge(['password' => $fieldhash]);

            //Crear usuario
            $user = User::create($request->all());

            //Asignar un rol
            $user->assignRole($request->role);

            DB::commit();
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
        }


        return redirect()->route('users.index')->with('success', 'usuario registrado');
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
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            /*Comprobar el password y aplicar el hash*/
            if (empty($request->password)) {

                //que el request excluya al campo password
                $request = Arr::except($request, array('password'));
            } else {
                $fieldhash = Hash::make($request->password);
                $request->merge(['password'=>$fieldhash]);
            }
            $user->update($request->all());

            /*Actualizar rol*/
            $user->syncRoles([$request->role]);

            DB::commit();
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
        }


        return redirect()->route('users.index')->with('success', 'usuario registrado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        
        //eliminar el rol asociado al usuario
        $rolUser = $user->getRoleNames()->first();
        $user->removeRole($rolUser);

        //Eliminar un usuario
        $user->delete();

        return redirect()->route('users.index')->with('success', 'usuario eliminado');

    }
}
