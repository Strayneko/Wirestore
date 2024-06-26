<?php

namespace App\Livewire\Modal\Admin\Product;

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Category;
use App\Service\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class AddProductModal extends ModalComponent
{
    use WithFileUploads;

    public ProductForm $form;

    public Collection $categories;

    private ProductService $productService;

    public function boot()
    {
        $this->productService = new ProductService();
    }

    public function mount()
    {
        $this->dispatch('modal-product-opened');
        $this->categories = Category::all();
    }

    /**
     * Generate unique slug based on product name when product name field updated
     * @return void
     */
    public function updatedFormName(): void
    {
        $this->form->slug = $this->productService->generateSlug($this->form->name);
    }

    /**
     * Store product
     * @return void
     */
    public function saveProduct(): void
    {
        $this->form->isAddMode = true;
        $this->form->validate();

        $product = $this->productService->store($this->form);
        if(is_null($product)) {
            $this->dispatch('swal:message', message: 'Failed to store product. Please try again later.', title: 'Something went wrong!', type: 'error');
            return;
        }

        $this->dispatch('swal:message', message: 'Product has been stored successfully.');
        $this->closeModal();
        $this->dispatch('product:refresh');
    }

    /** {@inheritDoc} */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    /** {@inheritDoc} */
    public static function dispatchCloseEvent(): bool
    {
        return true;
    }

    /**
     * Reset form when modalClosed event fired
     * @return void
     */
    #[On('modalClosed')]
    public function resetFormOnModalClosed(): void
    {
        $this->form->resetForm();
    }

    public function render()
    {
        return view('livewire.modal.admin.product.add-product-modal');
    }
}
