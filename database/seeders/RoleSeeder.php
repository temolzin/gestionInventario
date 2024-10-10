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
        $admin = Role::create(['name' => 'admin']);
        $supervisor = Role::create(['name' => 'supervisor']);

        Permission::create(['name' => 'users', 'description' => 'Gestión de usuarios'])->assignRole($admin);
        Permission::create(['name' => 'roles', 'description' => 'Visualizar lista de roles'])->assignRole($admin);
        Permission::create(['name' => 'category', 'description' => 'Visualizar Categorias'])->assignRole($supervisor);
        Permission::create(['name' => 'students', 'description' => 'Visualizar Estudiantes'])->assignRole($supervisor);
        Permission::create(['name' => 'materials', 'description' => 'Visualizar Materiales'])->assignRole($supervisor);
        Permission::create(['name' => 'departments', 'description' => 'Visualizar Departamentos'])->assignRole($admin);
        Permission::create(['name' => 'inventories', 'description' => 'Visualizar Inventario'])->assignRole($supervisor);
        Permission::create(['name' => 'loans', 'description' => 'Visualizar Prestamos'])->assignRole($supervisor);
    }
}
