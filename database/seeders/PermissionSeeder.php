<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create admin
        $admin = \App\Models\User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'role_id' => Role::ADMIN->value,

            ]);

        // create customer
        $customer = \App\Models\User::create(
            [
                'name' => 'Customer',
                'email' => 'customer@customer.com',
                'password' => bcrypt('123456'),
                'role_id' => Role::CUSTOMER->value,

            ]);
    }
}
