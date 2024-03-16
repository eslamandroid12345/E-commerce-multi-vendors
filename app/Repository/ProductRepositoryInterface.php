<?php

namespace App\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getAllProducts() : LengthAwarePaginator;
}
