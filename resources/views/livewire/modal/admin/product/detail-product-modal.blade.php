<x-modal.modal title="Detail Product">
    <div class="flex gap-4">
        <div class="w-1/2 border border-2 border-gray-300 rounded flex justify-center items-center">
            <img src="{{ asset($product->productImage?->full_path) }}" alt="{{ $product->name }}" class="w-full">
        </div>

        <div class="w-1/2">
            <span class="text-gray-800 font-bold uppercase text-xl">{{ $product->name }}</span>
            <hr class="my-2" />
            <div>
                <div class="flex gap-5 text-gray-600">
                    <div class="w-1/6">Stock</div>
                    <div class="font-semibold">{{ number_format($product->stock) }}</div>
                </div>

                <div class="flex gap-5 text-gray-600">
                    <div class="w-1/6">Price</div>
                    <div class="font-semibold">${{ number_format($product->price) }}</div>
                </div>

                <div class="flex gap-5 text-gray-600">
                    <div class="w-1/6">Category</div>
                    <div class="font-semibold">{{$product->category->name }}</div>
                </div>
            </div>

            <hr class="my-4" />

            <div>
                <span class="font-semibold text-gray-800 uppercase">Product Description</span>
                <p class="text-gray-600">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</x-modal.modal>
