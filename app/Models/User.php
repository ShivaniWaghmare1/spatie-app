<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Determine if the model may perform the given permission.
     *
     * @param  string|int|\Spatie\Permission\Contracts\Permission  $permission
     * @param  string|null  $guardName
     *
     * @throws PermissionDoesNotExist
     */
    public function checkHasPermissionTo($permission, $guardName = null): bool
    {
        // Connect to Redis (assuming it's running on localhost with default port)
        $redis = new Redis();

        // Generate a unique cache key based on the user ID and permission name
        $cacheKey = 'permission:' . $this->id . ':' . $permission;

        // Check if the permission check result exists in Redis cache
        if ($redis::get($cacheKey)) {
            return (bool) $redis::get($cacheKey);
        }

        // If not in cache, then perform the permission check using Spatie's hasPermissionTo method
        $hasPermission = $this->hasPermissionTo($permission, $guardName);

        // Cache the result with a TTL of 60 seconds (1 minute)
        $redis::setex($cacheKey, 60, (int) $hasPermission);

        return $hasPermission;
    }
}
