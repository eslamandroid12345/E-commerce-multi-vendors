<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $array_ar = [
            'الفساتين',
            'التنانير',
            'البناطيل والسراويل',
            'البدلات',
            'القمصان والبلوزات',
            'السترات والجاكيتات',
            'الملابس الداخلية الرسمية',
            'السترات والمعاطف',
            'الفساتين الشتوية',
            'البيجامات',
            ###########
            'طاولة الطعام',
            'كنبة جلدية',
            'خزانة ملابس',
            'سرير مزدوج',
            'مكتب كمبيوتر',
            'مرآة حائط',
            'طاولة قهوة',
            'كرسي مكتبي',
            'رفوف حائط',
            'طقم غرفة نوم',
            #######################
            'هاتف ذكي',
            'هاتف محمول',
            'هاتف قابل للطي',
            'هاتف لوحي',
            'هاتف بكاميرا مزدوجة',
            'هاتف بشاشة كبيرة',
            'هاتف ببطارية قوية',
            'هاتف بتقنية 5G',
            'هاتف بذاكرة كبيرة',
            'هاتف بمعالج قوي',
            #############################
            'تلفاز ذكي',
            'لابتوب',
            'كاميرا رقمية',
            'سماعات لاسلكية',
            'جهاز تابلت',
            'هاتف ذكي',
            'مكبر صوت بلوتوث',
            'ساعة ذكية',
            'جهاز تسجيل صوتي',
            'ماسح ضوئي',
            ];



        $array_en = [
            'dresses',
            'skirts',
            'trousers and trousers',
            'suits',
            'shirts and blouses',
            'jackets and jackets',
            'formal underwear',
            'jackets and coats',
            'winter dresses',
            'pajamas',
            ###############
            'Dining table',
            'Leather sofa',
            'Wardrobe',
            'Double bed',
            'Computer desk',
            'Wall mirror',
            'Coffee table',
            'Office chair',
            'Wall shelves',
            'Bedroom set',
            #########################
            'Smartphone',
            'Mobile phone',
            'Foldable phone',
            'Tablet',
            'Phone with dual camera',
            'Phone with large screen',
            'Phone with strong battery',
            '5G phone',
            'Phone with large memory',
            'Phone with powerful processor',
            ##########################################
            'Smart TV',
            'Laptop',
            'Digital camera',
            'Wireless headphones',
            'Tablet device',
            'Smartphone',
            'Bluetooth speaker',
            'Smartwatch',
            'Voice recorder',
            'Scanner',

            ];

        for ($i = 0 ; $i < 10 ; $i++){

            $sub_category = new SubCategory();
            $sub_category->image = 'storage/sub_categories/images/'.$i.'.jfif';
            $sub_category->is_active = true;
            $sub_category->tags = $array_ar[$i].'-'.$array_en[$i];
            $sub_category->category_id = 1;
            $sub_category->save();
            $sub_category->translateOrNew("ar")->name =  $array_ar[$i];
            $sub_category->translateOrNew("en")->name =  $array_en[$i];
            $sub_category->save();
        }//end loop

        ####################################################################################################


        for ($j = 10 ; $j < 20 ; $j++){

            $sub_category = new SubCategory();
            $sub_category->image = 'storage/sub_categories/images/'.$j.'.png';
            $sub_category->is_active = 1;
            $sub_category->tags = $array_ar[$j].'-'.$array_en[$j];
            $sub_category->category_id = 2;
            $sub_category->save();
            $sub_category->translateOrNew("ar")->name =  $array_ar[$j];
            $sub_category->translateOrNew("en")->name =  $array_en[$j];
            $sub_category->save();
        }//end loop



        ####################################################################################################

        for ($k = 20 ; $k < 30 ; $k++){

            $sub_category = new SubCategory();
            $sub_category->image = 'storage/sub_categories/images/'.$k.'.png';
            $sub_category->is_active = 1;
            $sub_category->tags = $array_ar[$k].'-'.$array_en[$k];
            $sub_category->category_id = 3;
            $sub_category->save();
            $sub_category->translateOrNew("ar")->name =  $array_ar[$k];
            $sub_category->translateOrNew("en")->name =  $array_en[$k];
            $sub_category->save();
        }//end loop


        ####################################################################################################

        for ($l = 30 ; $l < 40 ; $l++){

            $sub_category = new SubCategory();
            $sub_category->image = 'storage/sub_categories/images/'.$l.'.jpg';
            $sub_category->is_active = 1;
            $sub_category->tags = $array_ar[$l].'-'.$array_en[$l];
            $sub_category->category_id = 4;
            $sub_category->save();
            $sub_category->translateOrNew("ar")->name =  $array_ar[$l];
            $sub_category->translateOrNew("en")->name =  $array_en[$l];
            $sub_category->save();
        }//end loop

    }
}
