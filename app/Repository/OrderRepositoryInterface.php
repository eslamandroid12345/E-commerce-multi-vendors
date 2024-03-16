<?php

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getAllOrders() : LengthAwarePaginator;

    public function getOrdersSeller($id) : LengthAwarePaginator;

    public function filter($category_id=null,$brand_id=null,$status=null,$placed_date=null,$payment_gateway=null,$price_from=null,$price_to=null) : LengthAwarePaginator;

}
