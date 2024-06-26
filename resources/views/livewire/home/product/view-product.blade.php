<div>
    <!-- breadcrumb -->
    <div class="container py-4 flex items-center gap-3">
        <a href="{{ route('home.index') }}" class="text-primary text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium">Product</p>
    </div>
    <!-- ./breadcrumb -->

    <!-- product-detail -->
    <div class="container grid grid-cols-2 gap-6">
        <div>
            <img src="{{ asset($product->productImage->full_path) }}" alt="{{ $product->name }}" class="w-full">
            <div class="grid grid-cols-5 gap-4 mt-4">
                <img src="{{ asset($product->productImage->full_path) }}" alt="{{ $product->name }}"
                     class="w-full cursor-pointer border border-primary">
            </div>
        </div>

        <div>
            <h2 class="text-3xl font-medium uppercase mb-2">{{ $product->name }}</h2>
            <div class="flex items-center mb-4">
                <div class="flex gap-1 text-sm text-yellow-400">
                    <span><i class="fa-solid fa-star"></i></span>
                    <span><i class="fa-solid fa-star"></i></span>
                    <span><i class="fa-solid fa-star"></i></span>
                    <span><i class="fa-solid fa-star"></i></span>
                    <span><i class="fa-solid fa-star"></i></span>
                </div>
                <div class="text-xs text-gray-500 ml-3">(150 Reviews)</div>
            </div>
            <div class="space-y-2">
                <p class="text-gray-800 font-semibold space-x-2">
                    <span>Availability: </span>
                    @if($product->stock === 0)
                        <span class="text-red-600">Sold Out</span>
                    @else
                        <span class="text-green-600">In Stock</span>
                    @endif
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Category: </span>
                    <span class="text-gray-600">{{ $product->category->name }}</span>
                </p>
            </div>
            <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
                <p class="text-xl text-primary font-semibold">${{ number_format($product->price) }}</p>
{{--                <p class="text-base text-gray-400 line-through">$55.00</p>--}}
            </div>

            <p class="mt-4 text-gray-600">{{ $product->description }}</p>


            <div class="mt-4">
                <h3 class="text-sm text-gray-800 uppercase mb-1">Quantity</h3>
                <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                    <div class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none">-</div>
                    <div class="h-8 w-8 text-base flex items-center justify-center">4</div>
                    <div class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none">+</div>
                </div>
            </div>

            <div class="mt-6 flex gap-3 border-b border-gray-200 pb-5 pt-5">
                <a href="#"
                   class="bg-primary border border-primary text-white px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:bg-transparent hover:text-primary transition">
                    <i class="fa-solid fa-bag-shopping"></i> Add to cart
                </a>
                <a href="#"
                   class="border border-gray-300 text-gray-600 px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:text-primary transition">
                    <i class="fa-solid fa-heart"></i> Wishlist
                </a>
            </div>

            <div class="flex gap-3 mt-4">
                <a href="#"
                   class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#"
                   class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="#"
                   class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- ./product-detail -->

    <!-- description -->
    <div class="container pb-16">
        <h3 class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium">Product details</h3>
        <div class="w-3/5 pt-6">
            <div class="text-gray-600">
                {{ $product->description }}
            </div>
        </div>
    </div>
    <!-- ./description -->
</div>
