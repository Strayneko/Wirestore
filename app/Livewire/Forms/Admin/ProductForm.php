<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class ProductForm extends Form
{
    #[Validate('required|min:5|max:255', as: 'product name')]
    public ?string $name = null;

    #[Validate('required|min:3|unique:products', as: 'product slug')]
    public ?string $slug = null;

    #[Validate('required|min:5', as: 'product description')]
    public ?string $description = null;

    #[Validate('required|numeric|min:100')]
    public ?string $price = null;

    #[Validate('required|numeric|min:1')]
    public ?string $stock = null;

    public bool $isPublished = true;

    #[Validate('required|file|image|mimes:jpg,png,jpeg|max:4096')]
    public ?TemporaryUploadedFile $image = null;

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
}
