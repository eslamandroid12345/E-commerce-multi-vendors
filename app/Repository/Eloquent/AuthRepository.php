<?php

namespace App\Repository\Eloquent;

use App\Models\Admin;
use App\Models\User;
use App\Repository\AuthRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AuthRepository  extends Repository implements AuthRepositoryInterface
{
    protected Model $model;

    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }
    public function getAllSellers()
    {
        return $this->model::query()
            ->where('user_type', 'seller')
            ->when(request()->has('name'), function ($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            })
            ->latest()
            ->paginate(10);
    }

}
