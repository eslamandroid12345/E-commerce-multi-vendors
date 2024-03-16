<?php

namespace App\Repository\Eloquent;

use App\Models\Brand;
use App\Repository\BrandRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BrandRepository extends Repository implements BrandRepositoryInterface
{
    protected Model $model;

    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    public function getAllBrands(): LengthAwarePaginator
    {
        $query = $this->model::query();

        $query->when(request()->has('name') && request('name') != null, function ($q)  {
            $q->whereTranslationLike('name', '%' . request('name') . '%');
        });

        return $query
            ->latest()
            ->select(['*'])
            ->paginate(10);

    }
}
