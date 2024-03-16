<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(LaratrustSeeder::class);

        $this->call([
            UserSeeder::class,
            AdminTableSeeder::class,
            BrandTableSeeder::class,
            CategoryTableSeeder::class,
            SubCategoryTableSeeder::class,
            AssignRoleUser::class,
            ProductTableSeeder::class,
            OrderTableSeeder::class,
        ]);

    }
}
