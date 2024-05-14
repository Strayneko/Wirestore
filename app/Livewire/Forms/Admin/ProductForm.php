<?php

namespace App\Livewire\Forms\Admin;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class ProductForm extends Form
{
    public $isAddMode = false;

    public ?int $productId = null;

    #[Validate('required|min:5|max:255', as: 'product name')]
    public ?string $name = null;

    #[Validate(as: 'product slug')]
    public ?string $slug = null;

    #[Validate('required|min:5', as: 'product description')]
    public ?string $description = null;

    #[Validate('required|numeric|min:100')]
    public ?string $price = null;

    #[Validate('required|numeric|min:0')]
    public ?string $stock = null;

    #[Validate('nullable|required_if:isAddMode,true|file|image|mimes:jpg,png,jpeg|max:4096', message: ['required_if' => 'The image filed is required.'])]
    public ?TemporaryUploadedFile $image = null;

    #[Validate(['required', 'exists:categories,id'], as: 'product category')]
    public ?string $category = null;

    public bool $isPublished = true;

    /**
     * Reset livewire model
     * @return void
     */
    public function resetForm(): void
    {
        $this->reset(
            'name',
            'slug',
            'description',
            'price',
            'slug',
            'stock',
            'image',
            'isPublished',
        );
    }

    /**
     * Set validation rules
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'min:3', Rule::unique('products', 'slug')->ignore($this->productId)],
        ];
    }
}
