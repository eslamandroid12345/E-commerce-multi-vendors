<?php

namespace App\Repository;

use App\Models\ProductFeatureDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductFeatureRepositoryInterface extends RepositoryInterface
{

    public function getAllFeaturesByProductId($productId): Collection|array;
    public function createProductFeature($product, $featureData): ?Model;
    public function productFeaturesWithDetails($product): Collection|array;
    public function productFeaturesWithQuantities($product): Collection|array;

    public function deleteOldFeatures($productId);

    public function updateProductFeature($product,$featureData);



}
