<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Seeder para crear un usuario administrador
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear un usuario administrador
        $user = User::create([
            'name' => 'David',
            'apellido' => 'Montes',
            'email' => 'admin@demo.com',
            'password' => bcrypt('12345678'),
            'wins' => 0
        ]);
        
        // Crear roles y asignar permisos
        $role = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'user']);
        $permissions = [
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'post-list',
            'exercise-create',
            'exercise-edit',
            'exercise-all',
            'exercise-delete'
        ];
        $role2->syncPermissions($permissions);
      

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);
        
        // Asignar el rol de administrador al usuario
        $user->assignRole([$role->id]);
    }
}
