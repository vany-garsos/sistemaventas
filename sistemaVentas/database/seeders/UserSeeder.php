<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = User::create([
                'name' => 'Bianca Yieh',
                'email' => 'bianca@gmail.com',
                'password' => bcrypt('12345678')
        ]);

        //Usuario administrador
        $rol = Role::create(['name'=>'administrador']);
        $permisos = Permission::pluck('id', 'id')->all();
        //asignar todos esos permisos a ese rol
        $rol->syncPermissions($permisos);
        $user->assignRole('administrador');

    }
}
