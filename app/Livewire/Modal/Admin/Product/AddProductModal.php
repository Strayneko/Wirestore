<?php

namespace App\Livewire\Modal\Admin\Product;

use App\Livewire\Forms\Admin\ProductForm;
use LivewireUI\Modal\ModalComponent;

class AddProductModal extends ModalComponent
{

    public ProductForm $form;

    public function addProduct(): void
    {
        $this->form->validate();
    }

    /** {@inheritDoc} */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }
    public function render()
    {
        return view('livewire.modal.admin.product.add-product-modal');
    }
}
