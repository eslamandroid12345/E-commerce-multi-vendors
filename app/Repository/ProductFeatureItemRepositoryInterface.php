<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

interface ProductFeatureItemRepositoryInterface extends RepositoryInterface
{

    public function getProductFeatureItems($product): Collection|array;
}
