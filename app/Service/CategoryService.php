<?php

namespace App\Service;

use App\Livewire\Forms\Admin\Category\CategoryForm;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService {

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

}
