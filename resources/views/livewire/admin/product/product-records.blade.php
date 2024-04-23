<div>
    <div class="flex gap-2 justify-between">
        <div class="flex gap-2">
            <form class="max-w-xs mb-3">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" class="block w-full p-2 ps-9 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Product name" required />
                </div>
            </form>

            <select id="countries" class="bg-gray-50 h-10 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>10</option>
                <option value="US">15</option>
                <option value="CA">20</option>
                <option value="FR">25</option>
                <option value="DE">30</option>
            </select>

            <select id="countries" class="bg-gray-50 h-10 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-30 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>All</option>
                <option value="US">Published</option>
                <option value="CA">Deleted</option>
                <option value="FR">Out of Stock</option>
                <option value="DE">Drafted</option>
            </select>
        </div>

        <div x-data="{isDisabled: false}">
            <button @click.prevent="isDisabled = true; $dispatch('openModal', { component: 'modal.admin.product.add-product-modal' })"
                    type="button"
                    :disabled="isDisabled"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 disabled:bg-gray-500 disabled:cursor-not-allowed"
                    x-on:modal-product-opened.window="isDisabled = false"
            >
                Add New
            </button>
            <!-- Main modal -->
        </div>
    </div>

    <div class="relative overflow-x-visible shadow-md sm:rounded-lg"
         x-data="{
            openModal(component, arguments = {}){
                $wire.dispatch('openModal', { component, arguments })
            }
         }"
    >
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Stock
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Options</span>
                </th>
            </tr>
            </thead>
            <tbody>

            @forelse($products as $product)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" wire:key="product-{{ $loop->index }}">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ number_format(($products->currentpage()-1) * $products->perpage() + $loop->index + 1) }}
                    </th>
                    <td class="px-6 py-4">
                        {{ __($product->name) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $product->category->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        ${{ number_format($product->price) }}
                    </td>
                        <td @class(['px-6 py-4', 'text-red-500 font-medium' => $product->stock == 0])>
                        {{ $this->productStock($product->stock) }}
                    </td>
                    <td class="px-6 py-4">
                        <button id="options-button-{{ $loop->iteration }}" data-dropdown-toggle="dropdown-{{ $loop->iteration }}" autohide class="text-white text-sm bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Options<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdown-{{ $loop->iteration }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="options-button-{{ $loop->iteration }}">
                                <li>
                                    <a href="#"
                                       class="block text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       @click.prevent="openModal('modal.admin.product.detail-product-modal', { product: @js($product->slug)})"
                                    >Detail</a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="block text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       @click.prevent="openModal('modal.admin.product.edit-product-modal', { product: @js($product->slug) })"
                                    >Edit</a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="block text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       wire:click="$dispatch('swal:confirmation', {eventDispatchName: 'product:delete', slug: @js($product->slug)})"
                                    >Delete</a>
                                </li>
                            </ul>
                        </div>
                    </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5 text-base font-medium">
                    No product records found...
                </td>
            </tr>
            @endforelse

            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links(data: ['scrollTo' => false]) }}
    </div>
</div>
