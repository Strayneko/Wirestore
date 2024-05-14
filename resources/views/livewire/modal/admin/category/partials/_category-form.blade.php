<form action="" wire:submit.prevent="saveCategory()" class="space-y-4">
    <div class="space-y-1">
        <x-label value="Category Name" required />
        <x-input class="w-full" placeholder="Category Name" wire:model.live.debounce.500ms="form.name" />
        <x-input-error for="form.name" />
    </div>

    <div class="space-y-1">
        <x-label value="Slug" required />
        <x-input class="w-full" placeholder="category-name" wire:model="form.slug" />
        <x-input-error for="form.slug" />
    </div>
</form>

<x-slot:footer>
    <div class="flex justify-end gap-2.5">
        <x-button class="bg-red-600 hover:bg-red-800 hover:text-white focus:bg-red-800 active:bg-red-800 disabled:bg-gray-500 disabled:cursor-not-allowed"
                  wire:loading.attr="disabled"
                  wire:click="$dispatch('closeModal')">Cancel</x-button>
        <x-button wire:click.prevent="saveCategory()"
                  class="bg-blue-600 hover:bg-blue-800 hover:text-white focus:bg-blue-800 active:bg-blue-600 disabled:bg-gray-500 disabled:cursor-not-allowed"
                  wire:loading.attr="disabled"
                  wire:target="form.slug, saveCategory"
        >{{ $type }} Category</x-button>
    </div>
</x-slot:footer>
