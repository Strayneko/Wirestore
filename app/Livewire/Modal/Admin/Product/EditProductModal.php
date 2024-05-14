<?php

namespace App\Livewire\Modal\Admin\Product;

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Category;
use App\Service\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use App\Models\Product;

class EditProductModal extends ModalComponent
{
    use WithFileUploads;

    public ?Product $product = null;

    public ProductForm $form;

    public Collection $categories;

    private ProductService $productService;

    public function boot()
    {
        $this->productService = new ProductService();
    }

    public function mount()
    {
       $this->form->name = $this->product->name;
       $this->form->slug = $this->product->slug;
       $this->form->price = $this->product->price;
       $this->form->stock = $this->product->stock;
       $this->form->productId = $this->product->id;
       $this->form->description = $this->product->description;
       $this->form->category = $this->product->category_id;

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
     * Save updated product to db
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveProduct(): void
    {
        $this->form->validate();

        $update = $this->productService->update($this->product, $this->form);
        if(is_null($update)) {
            $this->dispatch('swal:message', message: 'Failed to update product. Please try again later.', title: 'Something went wrong!', type: 'error');
            return;
        }

        $this->dispatch('swal:message', message: 'Product has been updated successfully.');
        $this->closeModal();
        $this->dispatch('product:refresh');
    }

    /** {@inheritDoc} */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public function render()
    {
        return view('livewire.modal.admin.product.edit-product-modal');
    }
}
