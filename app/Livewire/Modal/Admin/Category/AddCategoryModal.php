<?php

namespace App\Livewire\Modal\Admin\Category;

use LivewireUI\Modal\ModalComponent;

class AddCategoryModal extends ModalComponent
{
    public function mount()
    {
        $this->dispatch('modal-category-opened');
    }

    /** {@inheritDoc} */
    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render()
    {
        return view('livewire.modal.admin.category.add-category-modal');
    }
}
