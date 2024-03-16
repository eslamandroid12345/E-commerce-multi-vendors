<?php

namespace App\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BrandRepositoryInterface extends RepositoryInterface
{
    public function getAllBrands() : LengthAwarePaginator;
}
