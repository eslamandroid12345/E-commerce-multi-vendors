<?php

namespace App\Repository\Eloquent;

use App\Models\OrderDetail;
use App\Repository\OrderDetailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class OrderDetailRepository extends Repository implements OrderDetailRepositoryInterface
{
    protected Model $model;

    public function __construct(OrderDetail $model)
    {
        parent::__construct($model);
    }

}
