<?php

namespace App\Livewire\Forms\Admin\Category;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CategoryForm extends Form
{
    #[Validate(['required', 'min:3', 'string'], as: 'category name')]
    public ?string $name = null;

    #[Validate(as: 'category slug')]
    public ?string $slug = null;

    public ?int $categoryId = null;

    /**
     * Set validation rules
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'min:3', Rule::unique('categories', 'slug')->ignore($this->categoryId)],
        ];
    }

    /**
     * Reset forms
     * @return void
     */
    public function resetForm(): void
    {
        $this->reset([
            'name',
            'slug',
            'categoryId'
        ]);
    }
}
