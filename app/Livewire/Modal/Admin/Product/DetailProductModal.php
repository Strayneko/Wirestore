<?php

namespace App\Livewire\Modal\Admin\Product;

use App\Models\Product;
use LivewireUI\Modal\ModalComponent;

class DetailProductModal extends ModalComponent
{
    public ?Product $product = null;

    /** {@inheritDoc} */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public function render()
    {
        return view('livewire.modal.admin.product.detail-product-modal');
    }
}
