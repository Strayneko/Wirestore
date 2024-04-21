<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    /**
     * Relationship to related category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship to get product image
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(Image::class);
    }

    public function productImage(): Attribute
    {
        // Cache default product image
        if(!Cache::has('default_image')){
            $image = Image::query()->where('id', 1)->where('product_id', null)->first();
            Cache::put('default_image', $image, now()->addDay());
        }
        return Attribute::get(
                fn () => $this->image ?? Cache::get('default_image'),
            );
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
