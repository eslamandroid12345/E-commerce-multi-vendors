<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laratrust\LaratrustFacade as Laratrust;
use App\Models\Admin;

class AssignRoleUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = Admin::where('user_type','admin')->get();
        foreach($admins as $admin)
        {
            $admin->roles()->attach(1);
        }
    }
}
