<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllCustomers(): LengthAwarePaginator
    {
        $query = $this->model::query();

        $query->when(request()->has('name') && request('name') != null, function ($q)  {
            $q->where('name', 'like', '%' . request('name') . '%');
        });
        $query->when(request()->has('rank') && request('rank') != null, function ($q)  {
            $q->orderBy('created_at', request('rank') == 1 ? 'asc' : 'desc');
        });

        return $query
            ->with(['orders','products'])
            ->latest()
            ->select(['*'])
            ->paginate(10);
    }
}
