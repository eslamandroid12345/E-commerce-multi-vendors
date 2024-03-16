<?php

namespace App\Repository\Eloquent;

use App\Models\Cart;
use App\Repository\CartRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class CartRepository extends Repository implements CartRepositoryInterface
{
    protected Model $model;

    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }

}
