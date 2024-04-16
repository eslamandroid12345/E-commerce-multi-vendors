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
        $query->when(request()->has('rank') && request('rank') != null, function ($q)  {
            $q->orderBy('created_at', request('rank') == 1 ? 'asc' : 'desc');
        });

        return $query
            ->withCount(['products'])
            ->latest()
            ->select(['*'])
            ->paginate(10);
    }
}
