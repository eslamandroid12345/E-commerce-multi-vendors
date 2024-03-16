<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductFeatureDetail;
use App\Models\ProductFeatureItem;
use App\Models\ProductFeatureItemDetail;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $product = new Product();
        $product->product_code = "#dsvbsdD";
        $product->tags = "منتج رقم 1";
        $product->category_id = 1;
        $product->sub_category_id = 1;
        $product->brand_id = 1;
        $product->seller_id = 2;
        $product->save();
        $product->translateOrNew("ar")->name = 'منتج رقم 1';
        $product->translateOrNew("en")->name = 'Product Number 1';
        $product->translateOrNew("ar")->description = 'منتج رقم 1';
        $product->translateOrNew("en")->description = 'Product Number 1';
        $product->save();

        for ($i = 1 ; $i <= 5 ; $i++){

            ProductImage::create([

               'product_id' => 1,
               'image' => 'storage/products/images/'.$i.'.jpg',
            ]);
        }

        $array = [
           'ram',
           'storage',
           'size'
        ];


        for ($i = 0 ; $i <= 2 ; $i++){

           $productFeature = ProductFeature::create([
                'name' => $array[$i],
                'discrimination' => 'GB',
                'quantity' => 2,
                'product_id' => 1,
            ]);

           for ($j = 0 ; $j < $productFeature->quantity ; $j++){

                   ProductFeatureDetail::create([
                   'product_feature_id' => $productFeature->id,
                   'content' => 8,
               ]);
           }

        }

        $productFeatureModel = ProductFeature::query()
            ->where('product_id','=',1)
            ->pluck('quantity')
            ->toArray();

          $quantity = 1;

          foreach ($productFeatureModel as $number){
              $quantity *= $number;
          }


        for ($i = 1 ; $i <= $quantity ; $i++){
            ProductFeatureItem::create([
                'product_id' => 1,
                'product_price' => 100,
                'price' => 200,
                'discount' => 0,
                'quantity' => 100
            ]);

        }//end for loop


        $productFeatures = ProductFeature::query()
            ->where('product_id', 1)
            ->with('details')
            ->get();

        $arrays = [];

        foreach ($productFeatures as $productFeature) {
            $arrays[] = $productFeature->details->pluck('id');
        }

        $result = $this->nestedLoop($arrays);

        $productFeatureItems = ProductFeatureItem::query()
            ->where('product_id', 1)
            ->get();

        foreach ($productFeatureItems as $key => $item) {
            foreach ($result[$key] as $rslt) {
                    ProductFeatureItemDetail::create([
                        'product_feature_item_id' => $item->id,
                        'product_feature_detail_id' => $rslt,
                    ]);
            }
        }


    }//end method

    public function nestedLoop($arrays, $currentIndex = 0, $currentArray = []): array
    {
        $result = [];

        if ($currentIndex == count($arrays)) {
            return [$currentArray];
        }

        foreach ($arrays[$currentIndex] as $value) {
            $currentArray[$currentIndex] = $value;
            $result = array_merge($result, $this->nestedLoop($arrays, $currentIndex+1, $currentArray));
        }
        return $result;
    }


}
