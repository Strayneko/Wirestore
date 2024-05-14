<?php

namespace App\Livewire\Modal\Admin\Category;

use App\Livewire\Forms\Admin\Category\CategoryForm;
use App\Models\Category;
use App\Service\CategoryService;
use App\Service\SlugService;
use LivewireUI\Modal\ModalComponent;

class EditCategoryModal extends ModalComponent
{

    public CategoryForm $form;

    public ?Category $category = null;

    private CategoryService $categoryService;

    private SlugService $slugService;

    public function boot()
    {
        $this->slugService = new SlugService();
        $this->categoryService = new CategoryService();
    }

    public function mount()
    {
        if(is_null($this->category)) abort(404, 'Category not found');

        $this->form->name = $this->category->name;
        $this->form->slug = $this->category->slug;
    }

    /**
     * Generate slug from category name when category name updated
     * @return void
     */
    public function updatedFormName(): void
    {
        $this->form->slug = $this->slugService->generateSlug($this->form->name, Category::class);
    }

    /**
     * Save category to db
     * @return void
     */
    public function saveCategory(): void
    {
        $this->form->validateOnly('name');
        if($this->category->isDirty('slug')) {
            $this->form->validateOnly('slug');
        }

        $update = $this->categoryService->update($this->category, $this->form);

        if(is_null($update)) {
            $this->dispatch('swal:message', message: 'Failed to update category. Please try again later.', title: 'Something went wrong!', type: 'error');
            return;
        }

        $this->dispatch('swal:message', message: 'Category has been updated successfully.');
        $this->closeModal();
        $this->dispatch('category:refresh');
    }

    public function render()
    {
        return view('livewire.modal.admin.category.edit-category-modal');
    }
}
