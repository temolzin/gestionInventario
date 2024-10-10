<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;




class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'supervisor']);

        Permission::create(['name' => 'users', 'description' => 'Gestión de usuarios'])->assignRole($role1);
        Permission::create(['name' => 'roles', 'description' => 'Visualizar lista de roles'])->assignRole($role1);
        Permission::create(['name' => 'category', 'description' => 'Visualizar Categorias'])->assignRole($role2);
        Permission::create(['name' => 'students', 'description' => 'Visualizar Estudiantes'])->assignRole($role2);
        Permission::create(['name' => 'materials', 'description' => 'Visualizar Materiales'])->assignRole($role2);
        Permission::create(['name' => 'departments', 'description' => 'Visualizar Departamentos'])->assignRole($role1);
        Permission::create(['name' => 'inventories', 'description' => 'Visualizar Inventario'])->assignRole($role2);
        Permission::create(['name' => 'loans', 'description' => 'Visualizar Prestamos'])->assignRole($role2);
    }
}
