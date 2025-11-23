<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
    ];

    /**
     * The users that belong to the permission.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permission');
    }

    /**
     * Scope a query to only include permissions of a given category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get all unique permission categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getCategories()
    {
        return self::select('category')->distinct()->pluck('category');
    }
}
