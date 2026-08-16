<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Product Manager', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Order Manager', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Marketing Manager', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Customer Support', 'guard_name' => 'web']);
    }
}