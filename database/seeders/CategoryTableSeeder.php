<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $category = new Category();
        $category->image = 'storage/categories/images/1.jfif';
        $category->is_active = 1;
        $category->tags = 'cdsdhsjhd-dshgdhgdh';
        $category->save();
        $category->translateOrNew("ar")->name =  'الملابس';
        $category->translateOrNew("en")->name =  'Clothes';
        $category->save();


        $category = new Category();
        $category->image = 'storage/categories/images/2.jfif';
        $category->is_active = 1;
        $category->tags = 'cdsdhsjhd-dshgdhgdh';
        $category->save();
        $category->translateOrNew("ar")->name =  'الاثاث';
        $category->translateOrNew("en")->name =  'Furniture';
        $category->save();


        $category = new Category();
        $category->image = 'storage/categories/images/3.jfif';
        $category->is_active = 1;
        $category->tags = 'cdsdhsjhd-dshgdhgdh';
        $category->save();
        $category->translateOrNew("ar")->name =  'الهواتف';
        $category->translateOrNew("en")->name =  'Phones';
        $category->save();

        $category = new Category();
        $category->image = 'storage/categories/images/4.jfif';
        $category->is_active = 1;
        $category->tags = 'cdsdhsjhd-dshgdhgdh';
        $category->save();
        $category->translateOrNew("ar")->name =  'الالكترونيات';
        $category->translateOrNew("en")->name =  'Electronics';
        $category->save();

    }
}
