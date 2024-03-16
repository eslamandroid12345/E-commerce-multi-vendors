<?php

namespace App\Repository\Eloquent;

use App\Models\ProductFeatureItem;
use App\Repository\ProductFeatureItemRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductFeatureItemRepository extends Repository implements ProductFeatureItemRepositoryInterface
{

    protected Model $model;

    public function __construct(ProductFeatureItem $model)
   {
    parent::__construct($model);
   }

    public function getProductFeatureItems($product): Collection|array
    {
       return $this->model::query()
            ->where('product_id', $product->id)
            ->get();
    }
}
