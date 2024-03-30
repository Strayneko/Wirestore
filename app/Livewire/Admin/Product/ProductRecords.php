<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ProductRecords extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Product::query()->with('category')->latest()->paginate(10);
        return view('livewire.admin.product.product-records', compact('products'));
    }
}
