<?php

namespace App\Repository\Eloquent;

use App\Models\ProductFeatureDetail;
use App\Repository\ProductFeatureDetailRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductFeatureDetailRepository extends Repository implements ProductFeatureDetailRepositoryInterface
{

    protected Model $model;

    public function __construct(ProductFeatureDetail $model)
    {
        parent::__construct($model);
    }

}
