<?php

namespace App\Livewire\Home\Product;

use App\Models\Product;
use Livewire\Component;

class ViewProduct extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.home.product.view-product');
    }
}
