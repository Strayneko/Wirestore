<?php

namespace App\Livewire\Modal\Admin\Category;

use App\Livewire\Forms\Admin\Category\CategoryForm;
use App\Models\Category;
use App\Service\CategoryService;
use App\Service\SlugService;
use LivewireUI\Modal\ModalComponent;

class AddCategoryModal extends ModalComponent
{
    public CategoryForm $form;

    private SlugService $slugService;

    private CategoryService $categoryService;

    public function boot(): void
    {
        $this->slugService = new SlugService();
        $this->categoryService = new CategoryService();
    }

    public function mount()
    {
        $this->dispatch('modal-category-opened');
    }

    /**
     * Generate slug from category name when category name updated
     * @return void
     */
    public function updatedFormName(): void
    {
        $this->form->slug = $this->slugService->generateSlug($this->form->name, Category::class);
    }

    /** {@inheritDoc} */
    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    /**
     * Save category to the database
     * @return void
     */
    public function saveCategory()
    {
        $this->form->validate();
        $category = $this->categoryService->store($this->form);

        if(is_null($category)) {
            $this->dispatch('swal:message', message: 'Failed to store category. Please try again later.', title: 'Something went wrong!', type: 'error');
            return;
        }

        $this->dispatch('swal:message', message: 'Category has been stored successfully.');
        $this->closeModal();
        $this->dispatch('category:refresh');
    }

    public function render()
    {
        return view('livewire.modal.admin.category.add-category-modal');
    }
}
