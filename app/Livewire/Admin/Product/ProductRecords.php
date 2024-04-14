<?php

namespace App\Livewire\Admin\Product;

use App\Service\ProductService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductRecords extends Component
{
    use WithPagination;

    private ?ProductService $productService = null;

    public function boot(): void
    {
        $this->productService = new ProductService();
    }

    /**
     * Refresh product records when product:added event fired
     * @return void
     */
    #[On('product:added')]
    public function refreshProducts()
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $products = $this->productService->fetchProducts();
        return view('livewire.admin.product.product-records', compact('products'));
    }
}
