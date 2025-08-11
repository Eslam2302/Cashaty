<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'view categories',
            'add category',
            'edit category',
            'delete category',
            'view products',
            'add product',
            'edit product',
            'delete product',
            'view product',
            'view customers',
            'add customer',
            'edit customer',
            'delete customer',
            'view orders',
            'create order',
            'view order',
            'edit order',
            'add stock',
            'view stock',
            'add user',
            'view users',
            'edit user',
            'delete user',
            'view logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $cashier = Role::firstOrCreate(['name' => 'Cashier']);
        $storekeeper = Role::firstOrCreate(['name' => 'Storekeeper']);


        // Give permissions to roles
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo(Permission::all());

        $cashier->givePermissionTo([
            'create order', 'view orders', 'view order','edit order',
            'add customer','edit customer','view customers',
            'view products','view categories',
            'add stock','view stock']);


        $storekeeper->givePermissionTo(['add stock','view stock','view products','view categories','add product']);


        // Create default admin user ..

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        // Ensure role assigned
        $user->syncRoles(['Admin']);


    }
}