<?php

namespace App\Repository\Eloquent;

use App\Models\ProductImage;
use App\Repository\ProductImageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class ProductImageRepository extends Repository implements ProductImageRepositoryInterface
{
    protected Model $model;

    public function __construct(ProductImage $model)
    {
        parent::__construct($model);
    }


}
