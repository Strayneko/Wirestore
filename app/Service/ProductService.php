<?php

namespace App\Service;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use function Pest\Laravel\instance;

class ProductService {

    private Builder $query;

    public function __construct()
    {
        $this->query = Product::query();
    }

    /**
     * Fetch all products
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchProducts(?int $paginate = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Product::query()->with('category', 'image')->latest()->paginate(10);
    }


    /**
     * TODO: Update product with the specified product model
     * @param Product|null $product
     * @return bool
     */
    public function update(?Product $product): bool
    {
        if(!$product instanceof Product) return false;

        return true;
    }

    /**
     * Find one product based on the given id
     * @param int|null $id
     * @return Product|null
     */
    public function findOne(?int $id): ?\App\Models\Product
    {
        if(is_null($id)) return null;

        return new Product();
    }
}
