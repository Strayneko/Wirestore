<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "creating" event.
     */
    public function creating(Product $product): void
    {
       $newProductName = cleanAndTitleizeString($product->name);
       $product->name = $newProductName;
    }

    /**
     * Handle the Product "updating" event.
     */
    public function updating(Product $product): void
    {
        if($product->isDirty('name')){
            $newProductName = cleanAndTitleizeString($product->name);
            $product->name = $newProductName;
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
