<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'image' => 'storage/admins/images/logo_admin_1.png',
            'name' => 'super_admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('r@WYtAEBDgaV%pZx'),
            'user_type' => 'admin'
        ]);

        for ($i = 1 ; $i <= 3 ; $i++){
            Admin::create([
                'image' => 'storage/admins/images/logo_seller_'.$i.'.png',
                'name' => 'Seller '.$i,
                'store_name' => 'Store '.$i,
                'phone' => '0104282219'.$i,
                'email' => 'seller'.$i.'@gmail.com',
                'password' => Hash::make('r@WYtAEBDgaV%pZx'),
                'user_type' => 'seller'
            ]);
        }
    }
}
