<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    /**
     * Get all products related to category
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     *  Get the route key for the model.
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
