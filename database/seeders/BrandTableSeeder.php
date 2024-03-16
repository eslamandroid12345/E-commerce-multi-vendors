<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $brand = new Brand();
        $brand->image = 'storage/brands/images/1.png';
        $brand->is_active = 1;
        $brand->save();
        $brand->translateOrNew("ar")->name =  'سامسونج';
        $brand->translateOrNew("en")->name =  'Samsung';
        $brand->save();

        $brand = new Brand();
        $brand->image = 'storage/brands/images/2.png';
        $brand->is_active = 1;
        $brand->save();
        $brand->translateOrNew("ar")->name =  'لينوفو';
        $brand->translateOrNew("en")->name =  'Lenovo';
        $brand->save();

        $brand = new Brand();
        $brand->image = 'storage/brands/images/3.png';
        $brand->is_active = 1;
        $brand->save();
        $brand->translateOrNew("ar")->name =  'القطن';
        $brand->translateOrNew("en")->name =  'Cotton';
        $brand->save();


        $brand = new Brand();
        $brand->image = 'storage/brands/images/4.png';
        $brand->is_active = 1;
        $brand->save();
        $brand->translateOrNew("ar")->name =  'اوبو';
        $brand->translateOrNew("en")->name =  'Oppo';
        $brand->save();

        $brand = new Brand();
        $brand->image = 'storage/brands/images/5.jfif';
        $brand->is_active = 1;
        $brand->save();
        $brand->translateOrNew("ar")->name =  'ايكيا';
        $brand->translateOrNew("en")->name =  'IKEA';
        $brand->save();

        $brand = new Brand();
        $brand->image = 'storage/brands/images/6.png';
        $brand->is_active = 1;
        $brand->save();
        $brand->translateOrNew("ar")->name =  'ديل';
        $brand->translateOrNew("en")->name =  'Dell';
        $brand->save();

    }
}
