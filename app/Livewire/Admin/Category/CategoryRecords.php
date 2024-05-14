<?php

namespace App\Livewire\Admin\Category;

use App\Service\CategoryService;
use Illuminate\Support\Facades\Log;
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
     * Handle event comes from confirmation box to delete the categirt
     * @param string|null $slug
     * @return void
     */
    #[On('category:delete')]
    public function deleteCategory(?string $slug): void
    {
        if(is_null($slug)){
            Log::error("Cannot proceed to delete the category slug is null.");
            $this->dispatch('swal:message', title: 'Something went wrong!', message: 'Cannot delete this category, please try again later.', type: 'error');
            return;
        }

        $delete = $this->categoryService->destroy($slug);

        if(is_null($delete)){
            $this->dispatch('swal:message', title: 'Something went wrong!', message: 'This category is not found..', type: 'error');
            return;
        }

        if(!$delete){
            $this->dispatch('swal:message', title: 'Internal server error!', message: 'Cannot delete this category at the moment, please try again later.', type: 'error');
            return;
        }

        $this->dispatch('category:refresh');
        $this->dispatch('swal:message', message: 'Category has been deleted successfully.');
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
