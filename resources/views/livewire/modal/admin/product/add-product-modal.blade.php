<x-modal.modal title="Add Product" x-data>
    <form action="" class="space-y-5" wire:submit.prevent="addProduct()">
        <div class="space-y-1">
            <x-label value="Name" required />
            <x-input class="w-full" placeholder="Product Name" wire:model="form.name" />
            <x-input-error for="form.name" />
        </div>
    <div class="space-y-1">
            <x-label value="Slug" required />
            <x-input class="w-full" placeholder="product-name" />
            <x-input-error for="form.slug" />
        </div>

        <div class="space-y-1">
            <x-label value="Price (RP)" required />
            <x-input class="w-full" type="number" step="1" min="0" placeholder="10,000" />
            <x-input-error for="form.price" />
        </div>

        <div class="space-y-1">
            <x-label value="Stock" required />
            <x-input class="w-full" type="number" step="1" min="0" placeholder="100" />
            <x-input-error for="form.stock" />
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
            <input wire:model="form.image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none file:!bg-blue-600" aria-describedby="file_input_help" id="file_input" type="file">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
            <x-input-error for="form.image" />
        </div>
        <x-button class="hidden" type="submit" x-ref="addProductButton"></x-button>
    </form>

    <x-slot:footer>
        <div class="flex justify-end gap-2.5">
            <x-button class="bg-red-600 hover:bg-red-800 hover:text-white focus:bg-red-800 active:bg-red-800"
                      wire:click="$dispatch('closeModal')">Cancel</x-button>
            <x-button @click.prevent="$refs.addProductButton.click()"
                      class="bg-blue-600 hover:bg-blue-800 hover:text-white focus:bg-blue-800 active:bg-blue-600"
            >Add Product</x-button>
        </div>
    </x-slot:footer>
</x-modal.modal>
