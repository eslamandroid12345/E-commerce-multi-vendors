<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface AuthRepositoryInterface extends RepositoryInterface
{
    public function getAllSellers();
}
