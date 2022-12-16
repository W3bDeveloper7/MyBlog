<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->create([
            'name'      => 'Super Admin',
            'username'  => 'admin',
            'password'  => Hash::make('12345678'),
            'role_id'   => 2
        ]);

        User::factory()->count(10)->create();
    }
}
