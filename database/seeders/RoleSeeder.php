<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create our static roles Admin & Subscriber
        $subscriber = Role::create(['name'=>'Subscriber']);
        $admin      = Role::create(['name'=>'Admin']);
    }
}
