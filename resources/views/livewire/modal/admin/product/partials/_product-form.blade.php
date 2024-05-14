<form action="" class="space-y-5" wire:submit.prevent="saveProduct()">
    <div class="space-y-1">
        <x-label value="Name" required />
        <x-input class="w-full" placeholder="Product Name" wire:model.live.debounce.500ms="form.name" />
        <x-input-error for="form.name" />
    </div>
    <div class="space-y-1">
        <x-label value="Slug" required />
        <x-input class="w-full" placeholder="product-name" wire:model="form.slug" />
        <x-input-error for="form.slug" />
    </div>

    <div>
        <x-form.select id="categories"
                       label="Category"
                       model="form.category"
                       required
        >
            <option value="null">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </x-form.select>
    </div>

    <div class="space-y-1">
        <x-label value="Price (RP)" required />
        <x-input class="w-full" type="number" step="1" min="0" placeholder="10,000" wire:model="form.price" />
        <x-input-error for="form.price" />
    </div>

    <div class="space-y-1">
        <x-label value="Stock" required />
        <x-input class="w-full" type="number" step="1" min="0" placeholder="100" wire:model="form.stock" />
        <x-input-error for="form.stock" />
    </div>

    <div class="space-y-1">
        <x-label value="Description" required />
        <textarea wire:model="form.description"
                  rows="4"
                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Describe your products here..."></textarea>
        <x-input-error for="form.description" />
    </div>

    <div x-data="{ uploading: false, progress: 0 }"
         x-on:livewire-upload-start="uploading = true"
         x-on:livewire-upload-finish="uploading = false, progress = 0"
         x-on:livewire-upload-cancel="uploading = false, progress = 0"
         x-on:livewire-upload-error="uploading = false, progress = 0"
         x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <x-label value="Upload File" :required="$type === 'add'" class="mb-2" />

        <div x-show="uploading" x-cloak>
            <div class="flex justify-between mb-1">
                <span class="text-base font-medium text-blue-700 dark:text-white">Uploading image</span>
                <span class="text-sm font-medium text-blue-700 dark:text-white" x-text="`${progress}%`">0%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                <div class="bg-blue-600 h-4 rounded-full" :style="`width: ${progress}%`"></div>
            </div>
        </div>

        <div x-show="!uploading" x-cloak>
            <input wire:model="form.image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none file:!bg-blue-600" aria-describedby="file_input_help" id="file_input" type="file">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
        </div>
        <x-input-error for="form.image" />
    </div>
    <x-button class="hidden" type="submit" x-ref="saveProductButton"></x-button>
</form>

<x-slot:footer>
    <div class="flex justify-end gap-2.5">
        <x-button class="bg-red-600 hover:bg-red-800 hover:text-white focus:bg-red-800 active:bg-red-800 disabled:bg-gray-500 disabled:cursor-not-allowed"
                  wire:loading.attr="disabled"
                  wire:click="$dispatch('closeModal')">Cancel</x-button>
        <x-button @click.prevent="$refs.saveProductButton.click()"
                  class="bg-blue-600 hover:bg-blue-800 hover:text-white focus:bg-blue-800 active:bg-blue-600 disabled:bg-gray-500 disabled:cursor-not-allowed"
                  wire:loading.attr="disabled"
                  wire:target="form.image, form.slug, saveProduct"
        >{{ __($type === 'add' ? 'Add Product' : 'Save Product') }}</x-button>
    </div>
</x-slot:footer>
