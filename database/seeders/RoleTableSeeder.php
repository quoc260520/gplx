<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => User::ROLE_ADMIN]);
        Role::create(['name' => User::ROLE_STAFF]);
        Role::create(['name' => User::ROLE_CLIENT]);
    }
}
