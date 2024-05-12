<?php

namespace App\Livewire\Admin\Category;

use App\Service\CategoryService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryRecords extends Component
{
    use WithPagination;

    private CategoryService $categoryService;

    public function boot(): void
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * Refresh product records when product:added event fired
     * @return void
     */
    #[On('category:refresh')]
    public function refreshProducts(): void
    {
        $this->dispatch('$refresh');
    }

    /**
     * Refresh category record every paginator page changed
     * @return void
     */
    public function updatingPaginators(): void
    {
        $this->dispatch('category:refresh');
    }

    public function render()
    {
        $categories = $this->categoryService->fetchCategories();
        return view('livewire.admin.category.category-records', ['categories' => $categories]);
    }
}
