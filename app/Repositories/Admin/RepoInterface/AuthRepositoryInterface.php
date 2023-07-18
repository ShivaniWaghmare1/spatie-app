<?php

namespace App\Repositories\Admin\RepoInterface;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function create(Request $request);
}
