<?php

namespace App\Service;

use App\Livewire\Forms\Admin\Category\CategoryForm;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService {

    /**
     * Store category to db
     * @param CategoryForm $data
     * @return Category|null
     */
    public function store(CategoryForm $data): ?Category
    {
        try{
            $category = new Category();
            $category->name = $data->name;
            $category->slug = $data->slug;

            $category->save();

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }

        return $category;
    }


    /**
     * Fetch all categories
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchCategories(?int $paginate = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Category::query()->latest()->paginate(10);
    }

    /**
     * Update the given category with the given data
     * @param Category|null $category
     * @param CategoryForm $data
     * @return Category|null
     */
    public function update(?Category $category, CategoryForm $data): ?Category
    {
        if(is_null($category)) return null;

        try{
            $category->name = $data->name;
            $category->slug = $data->slug;

            $category->save();

            return $category;
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }
    /**
     * Find one category based on the given id
     * @param int|null $id
     * @return \App\Models\Category|null
     */
    public function findOne(?string $slug): ?\App\Models\Category
    {
        if(is_null($slug)) return null;

        return Category::query()->where('slug', $slug)->first();
    }

    /**
     * Delete category based on the given slug
     * @param string|null $slug
     * @return bool|null
     */
    public function destroy(?string $slug): ?bool
    {
        $category = $this->findOne($slug);

        if (is_null($category)) {
            Log::error("Failed to find category with slug = {$slug}.");
            return null;
        }
        try{
            return $category->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());

            return null;
        }

    }

}
