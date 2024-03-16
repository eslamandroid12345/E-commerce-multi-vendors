<?php

namespace App\Repository\Eloquent;

use App\Models\SubCategory;
use App\Repository\SubCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class SubCategoryRepository extends Repository implements SubCategoryRepositoryInterface
{
    protected Model $model;

    public function __construct(SubCategory $model)
    {
        parent::__construct($model);
    }

    public function getAllSubCategories(): LengthAwarePaginator
    {
        $query = $this->model::query();

        $query->when(request()->has('name') && request('name') != null, function ($q)  {
            $q->whereTranslationLike('name', '%' . request('name') . '%');
        });

        return $query
            ->withCount(['products'])
            ->latest()
            ->select(['*'])
            ->paginate(10);
    }
}
