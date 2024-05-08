<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryRecords extends Component
{
    use WithPagination;

    public function render()
    {
        $categories = Category::query()->paginate(5);
        return view('livewire.admin.category.category-records', ['categories' => $categories]);
    }
}
