<?php

namespace App\Service;

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Image;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Filesystem\Filesystem;
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
    public function update(?Product $product, ProductForm $data): bool
    {
        if(is_null($product)) return false;

        try{
            $update = $this->setProductAttribute($product, $data);
            if($data->image){
                $this->deleteImage($product->image);
                $this->storeImage($data->image, $product);
            }
            return $update;
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Find one product based on the given id
     * @param int|null $id
     * @return \App\Models\Product|null
     */
    public function findOne(?string $slug): ?\App\Models\Product
    {
        if(is_null($slug)) return null;

        return Product::query()->where('slug', $slug)->first();
    }

    public function destroy(?string $slug): ?bool
    {
        $product = $this->findOne($slug);

        if(is_null($product)){
            Log::error("Failed to find product with slug = {$slug}.");
            return null;
        }

        $this->deleteImage($product->image);
        return $product->delete();
    }

    /**
     * Store product information to database
     * @param \App\Livewire\Forms\Admin\ProductForm $data
     * @return \App\Models\Product|null
     */
    public function store(ProductForm $data): ?Product
    {
        try{
            $product = new Product();
            $this->setProductAttribute($product, $data);

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

    /**
     * Delete image from db and storage
     * @param \App\Models\Image|null $image
     * @return void
     */
    public function deleteImage(?Image $image): void
    {
        $isDefaultImage = $image?->id === 1;
        if(is_null($image) || $isDefaultImage) return;
        
        try{
            if($this->getStorageClass()->exists($image->full_path)){
                $this->getStorageClass()->delete($image->full_path);
            }

            $image->delete();
        }catch(\Exception $e){
            Log::error("Failed to delete product image. Reason: {$e->getMessage()}");
        }
    }

    /**
     * Get storage class
     * @return Filesystem
     */
    private function getStorageClass(): Filesystem
    {
        return Storage::disk('public');
    }

    /**
     * Set product model attribute with the given data from form
     * @param \App\Models\Product|null $product
     * @param \App\Livewire\Forms\Admin\ProductForm $data
     * @return bool
     */
    private function setProductAttribute(?Product $product, ProductForm $data): bool
    {
        if(is_null($product)) return false;

        $product->name = $data->name;
        $product->slug = $data->slug;
        $product->price = $data->price;
        $product->stock = $data->stock;
        $product->category_id = 1;
        $product->description = $data->description;
        $product->is_published = $data->isPublished;

        return $product->save();
    }
}
