<?php

namespace App\Livewire\Home;

use App\Service\ProductService;
use Livewire\Component;

class Products extends Component
{

    private ?ProductService $productService = null;

    public function boot(): void
    {
        $this->productService = new ProductService();
    }
    public function render()
    {
        $products = $this->productService->fetchProducts();
        return view('livewire.home.products', compact('products'));
    }
}
