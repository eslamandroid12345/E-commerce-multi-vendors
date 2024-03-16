<?php

namespace App\Repository\Eloquent;

use App\Models\ProductFeatureItem;
use App\Models\ProductFeatureItemDetail;
use App\Repository\ProductFeatureItemDetailRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\GreaterThan;

class ProductFeatureItemDetailRepository extends Repository implements ProductFeatureItemDetailRepositoryInterface
{

    protected Model $model;

    public function __construct(ProductFeatureItemDetail $model)
   {
    parent::__construct($model);
   }




}
