<?php

namespace App\Livewire\Admin\Product;

use App\Service\ProductService;
use Illuminate\Support\Facades\Log;
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
    #[On('product:refresh')]
    public function refreshProducts(): void
    {
        $this->dispatch('$refresh');
    }

    /**
     * Refresh product record every paginator page changed
     * @return void
     */
    public function updatingPaginators(): void
    {
        $this->dispatch('product:refresh');
    }

    /**
     * Handle event comes from confirmation box to delete the product
     * @param string|null $slug
     * @return void
     */
    #[On('product:delete')]
    public function deleteProduct(?string $slug): void
    {
        if(is_null($slug)){
            Log::error("Cannot proceed to delete the product slug is null.");
            $this->dispatch('swal:message', title: 'Something went wrong!', message: 'Cannot delete this product, please try again later.', type: 'error');
            return;
        }

       $delete = $this->productService->destroy($slug);

        if(is_null($delete)){
            $this->dispatch('swal:message', title: 'Something went wrong!', message: 'This product is not found..', type: 'error');
            return;
        }

        if(!$delete){
            $this->dispatch('swal:message', title: 'Internal server error!', message: 'Cannot delete this product at the moment, please try again later.', type: 'error');
            return;
        }

        $this->dispatch('$refresh');
        $this->dispatch('swal:message', message: 'Product has been deleted successfully.');
    }

    /**
     * Get product stock and return out of stock when product stock is zero
     * @param string|null $stock
     * @return string
     */
    public function productStock(?string $stock): string
    {
        if($stock <= 0) return 'Out of stock';

        return number_format($stock);
    }

    public function render()
    {
        $products = $this->productService->fetchProducts();
        return view('livewire.admin.product.product-records', compact('products'));
    }
}
