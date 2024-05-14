<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "creating" event.
     */
    public function creating(Category $category): void
    {
        $newCategoryName = cleanAndTitleizeString($category->name);
        $category->name = $newCategoryName;
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updating(Category $category): void
    {
        if($category->isDirty('name')) {
            $newCategoryName = cleanAndTitleizeString($category->name);
            $category->name = $newCategoryName;
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
