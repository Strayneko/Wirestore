<?php

namespace App\Service;

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
     * @param \App\Models\Product|null $product
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
     * @return \App\Models\Product|null
     */
    public function findOne(?int $id): ?\App\Models\Product
    {
        if(is_null($id)) return null;

        return new Product();
    }

    /**
     * Store product information to database
     * @param \App\Livewire\Forms\Admin\ProductForm $data
     * @return \App\Models\Product|null
     */
    public function store(ProductForm $data): ?Product
    {
        try{
            $product = Product::query()->create([
                'name' => $data->name,
                'slug' => $data->slug,
                'category_id' => 1,
                'description' => $data->description,
                'price' => $data->price,
                'stock' => $data->stock,
                'is_published' => $data->isPublished,
            ]);

            $this->storeImage($data->image, $product);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }

        return $product;
    }

    /**
     * Generate unique slug based on product name
     * @param string|null $productName
     * @return string|null
     */
    public function generateSlug(?string $productName): ?string
    {
        $productNameInvalid = is_null($productName) || (!is_null($productName) && strlen($productName) === 0);
        if($productNameInvalid) return null;

        return SlugService::createSlug(Product::class, 'slug', $productName, ['unique' => true]);
    }

    /**
     * Store uploaded image to storage and store the image information into database
     * @param \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null $image
     * @param \App\Models\Product|null $product
     * @return int|null
     * @throws \Exception
     */
    public function storeImage(?TemporaryUploadedFile $image, ?Product $product): ?int
    {
        if(is_null($image) || is_null($product)) return null;

        try{
            $path = 'images/products';
            $imageFullName =  Storage::disk('public')->put($path, $image);
            $ext = $image->getClientOriginalExtension();
            $fileName = Str::of($imageFullName)->trim()->remove($path . '/')->remove(".{$ext}")->toString();

            $productImage = $product->image()->create([
                            'name' => $fileName,
                            'extension' => strtoupper($ext),
                            'full_path' => $imageFullName,
                            'size' => $image->getSize(),
                        ]);

            return $productImage->id;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
