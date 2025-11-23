<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
    ];

    /**
     * The permissions that belong to the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    /**
     * Check if user has admin role.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has a specific permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->permissions()->where('slug', $permission)->exists();
    }

    /**
     * Check if user has any of the given permissions.
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAnyPermission(array $permissions)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->permissions()->whereIn('slug', $permissions)->exists();
    }

    /**
     * Check if user has all of the given permissions.
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAllPermissions(array $permissions)
    {
        if ($this->isAdmin()) {
            return true;
        }

        $userPermissions = $this->permissions()->pluck('slug')->toArray();
        return count(array_intersect($permissions, $userPermissions)) === count($permissions);
    }
}
