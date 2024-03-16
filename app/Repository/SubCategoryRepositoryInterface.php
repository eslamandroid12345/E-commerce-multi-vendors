<?php

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SubCategoryRepositoryInterface extends RepositoryInterface
{

    public function getAllSubCategories() : LengthAwarePaginator;


}
