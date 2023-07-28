<?php

namespace App\Repositories\Admin\RepoInterface;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

interface AuthRepositoryInterface
{
    public function create(Request $request);
}
