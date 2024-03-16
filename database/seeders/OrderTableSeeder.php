<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

           $order = Order::create([
                'grand_total' => 400,
                'payment_method' => 'cash',
                'payment_gateway' => null,
                'user_id' => 1,
            ]);

           OrderDetail::create([
               'order_id' => $order->id,
               'product_feature_item_id' => 1,
               'item_price' => 200,
               'quantity' => 2,
               'seller_id' => 2,

           ]);

    }
}
