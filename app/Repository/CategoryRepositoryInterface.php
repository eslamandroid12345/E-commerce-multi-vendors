<?php

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface extends RepositoryInterface
{

    public function getAllCategories() : LengthAwarePaginator;
}
