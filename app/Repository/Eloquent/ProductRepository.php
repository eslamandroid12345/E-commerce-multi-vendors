<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    protected Model $model;

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
    public function getAllProducts(): LengthAwarePaginator
    {
        $query = $this->model::query();

        $query->when(request()->has('name') && request('name') != null, function ($q)  {
            $q->whereTranslationLike('name', '%' . request('name') . '%');
        });
        $query->when(request()->has('rank') && request('rank') != null, function ($q)  {
            $q->orderBy('created_at', request('rank') == 1 ? 'asc' : 'desc');
        });

        return $query
            ->latest()
            ->select(['*'])
            ->paginate(10);

    }

}
