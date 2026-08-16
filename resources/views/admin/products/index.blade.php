<x-admin-layout>

    <x-slot name="pageTitle">
        Products
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Products
        </h1>

        <a href="{{ route('products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Product
        </a>

    </div>

    @if(session('success'))

<div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">

    {{ session('success') }}

</div>

@endif

    <div class="bg-white rounded-lg shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Product</th>
                    <th class="p-4 text-left">Category</th>
                    <th class="p-4 text-left">SKU</th>
                    <th class="p-4 text-left">Price</th>
                    <th class="p-4 text-left">Stock</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                    <tr class="border-t">

                        <td class="p-4">{{ $product->id }}</td>

                        <td class="p-4">{{ $product->name }}</td>

                        <td class="p-4">
                            {{ $product->category?->name ?? '-' }}
                        </td>

                        <td class="p-4">{{ $product->sku }}</td>

                        <td class="p-4">₹{{ $product->price }}</td>

                        <td class="p-4">{{ $product->stock }}</td>

                        <td class="p-4">

                            @if($product->status)
                                <span class="text-green-600">Active</span>
                            @else
                                <span class="text-red-600">Inactive</span>
                            @endif

                        </td>

                        <td class="p-4">

    <a href="{{ route('products.edit', $product->id) }}"
       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

        Edit

    </a>

</td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center p-6">

                            No Products Found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-admin-layout>