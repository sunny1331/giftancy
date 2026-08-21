<x-admin-layout>

    <x-slot name="pageTitle">
        Add Product
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Add Product
        </h1>

        <a href="{{ route('products.index') }}"
           class="bg-gray-700 text-white px-4 py-2 rounded">
            ← Back
        </a>

    </div>

    <div class="bg-white rounded-lg shadow p-6">

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form method="POST"
      action="{{ route('products.store') }}"
      enctype="multipart/form-data">

    @csrf

    <div class="grid grid-cols-2 gap-6">

        {{-- Product Name --}}
        <div>
            <label class="font-medium">Product Name *</label>

            <input
                type="text"
                name="name"
                class="w-full border rounded-lg mt-2 px-4 py-2"
                required>
        </div>

        <div class="mb-5">

    <label class="font-medium">
        Product Type
    </label>

    <select
        name="product_type"
        id="product_type"
        class="w-full border rounded-lg mt-2 px-4 py-2">

        <option value="simple">
            Simple Product
        </option>

        <option value="variable">
            Variable Product
        </option>

    </select>

</div>

        {{-- Category --}}
        <div>
            <label class="font-medium">Category *</label>

            <select
    name="category_id"
    id="category"
    class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="">Select Category</option>

                @foreach($categories as $category)

<option
    value="{{ $category->id }}"
    data-prefix="{{ $category->sku_prefix }}"
    data-next="{{ str_pad($category->next_sku_number,3,'0',STR_PAD_LEFT) }}">

    {{ $category->name }}

</option>

@endforeach

            </select>
        </div>

        {{-- SKU --}}
        <div>
            <label class="font-medium">SKU *</label>

            <input
                type="text"
                name="sku"
                class="w-full border rounded-lg mt-2 px-4 py-2"
                required>
        </div>

        {{-- Price --}}
        <div>
            <label class="font-medium">Selling Price *</label>

            <input
                type="number"
                step="0.01"
                name="price"
                class="w-full border rounded-lg mt-2 px-4 py-2"
                required>
        </div>

        {{-- Compare Price --}}
        <div>
            <label class="font-medium">Compare Price</label>

            <input
                type="number"
                step="0.01"
                name="compare_price"
                class="w-full border rounded-lg mt-2 px-4 py-2">
        </div>

        {{-- Cost Price --}}
        <div>
            <label class="font-medium">Cost Price</label>

            <input
                type="number"
                step="0.01"
                name="cost_price"
                class="w-full border rounded-lg mt-2 px-4 py-2">
        </div>

        {{-- Stock --}}
        <div id="stockField">
            <label class="font-medium">Stock Quantity</label>

            <input
                type="number"
                name="stock"
                value="0"
                class="w-full border rounded-lg mt-2 px-4 py-2">
        </div>

        {{-- Weight --}}
        <div>
            <label class="font-medium">Weight (kg)</label>

            <input
                type="number"
                step="0.01"
                name="weight"
                class="w-full border rounded-lg mt-2 px-4 py-2">
        </div>

        <div>

    <label class="block mb-2 font-medium">
        Dimensions
    </label>

    <div class="grid grid-cols-3 gap-3">

        {{-- Length --}}
        <div class="flex">

            <span class="px-3 border border-r-0 rounded-l-lg bg-gray-100 flex items-center font-medium">
                L
            </span>

            <input
                type="number"
                step="0.01"
                name="length"
                value="{{ old('length', $product->length ?? '') }}"
                class="w-full border-y border-gray-300 px-3 py-2 focus:outline-none">

            <span class="px-3 border border-l-0 rounded-r-lg bg-gray-100 flex items-center text-sm text-gray-600">
                CM
            </span>

        </div>

        {{-- Width --}}
        <div class="flex">

            <span class="px-3 border border-r-0 rounded-l-lg bg-gray-100 flex items-center font-medium">
                W
            </span>

            <input
                type="number"
                step="0.01"
                name="width"
                value="{{ old('width', $product->width ?? '') }}"
                class="w-full border-y border-gray-300 px-3 py-2 focus:outline-none">

            <span class="px-3 border border-l-0 rounded-r-lg bg-gray-100 flex items-center text-sm text-gray-600">
                CM
            </span>

        </div>

        {{-- Height --}}
        <div class="flex">

            <span class="px-3 border border-r-0 rounded-l-lg bg-gray-100 flex items-center font-medium">
                H
            </span>

            <input
                type="number"
                step="0.01"
                name="height"
                value="{{ old('height', $product->height ?? '') }}"
                class="w-full border-y border-gray-300 px-3 py-2 focus:outline-none">

            <span class="px-3 border border-l-0 rounded-r-lg bg-gray-100 flex items-center text-sm text-gray-600">
                CM
            </span>

        </div>

    </div>

</div>

    </div>

    {{-- Dynamic Attributes --}}
<div id="dynamicAttributes" class="mt-8">

</div>

<div id="variantSection" class="mt-8 hidden">

    <div class="bg-white rounded-lg shadow p-6">

        <h2 class="text-xl font-bold mb-6">
            Product Variants
        </h2>

        <div id="variantOptions">

        </div>

        <button
            type="button"
            id="generateVariants"
            class="mt-6 bg-green-600 text-white px-6 py-2 rounded-lg">

            Generate Variants

        </button>

        <div
            id="variantTable"
            class="mt-6">

        </div>

    </div>

</div>

    {{-- Description --}}
    <div class="mt-6">

        <label class="font-medium">
            Description
        </label>

        <textarea
            name="description"
            rows="6"
            class="w-full border rounded-lg mt-2 px-4 py-2"></textarea>

    </div>

    {{-- Featured Image --}}
    <div class="mt-6">

        <label class="font-medium">
            Featured Image
        </label>

        <input
            type="file"
            name="featured_image"
            class="w-full border rounded-lg mt-2 p-2">

    </div>

    <div class="mt-6">

    <label class="font-medium">
        Product Gallery
    </label>

    <input
        type="file"
        name="gallery[]"
        multiple
        class="w-full border rounded-lg mt-2 p-2">

    <p class="text-sm text-gray-500 mt-2">
        Hold Ctrl and select multiple images.
    </p>

</div>

{{-- Inventory --}}
<div class="mt-8 border-t pt-6">

    <h2 class="text-xl font-bold mb-5">
        Inventory
    </h2>

    <div class="grid grid-cols-2 gap-6">

        <div>

            <label class="font-medium">
                Track Inventory
            </label>

            <select
                name="track_inventory"
                class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="1" selected>
                    Yes
                </option>

                <option value="0">
                    No
                </option>

            </select>

        </div>

        <div>

            <label class="font-medium">
                Stock Status
            </label>

            <select
                name="stock_status"
                class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="in_stock" selected>
                    In Stock
                </option>

                <option value="out_of_stock">
                    Out of Stock
                </option>

                <option value="pre_order">
                    Pre Order
                </option>

            </select>

        </div>

        <div>

            <label class="font-medium">
                Low Stock Alert
            </label>

            <input
                type="number"
                name="low_stock_alert"
                value="5"
                class="w-full border rounded-lg mt-2 px-4 py-2">

        </div>

        <div>

            <label class="font-medium">
                Continue Selling
            </label>

            <select
                name="continue_selling"
                class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="0" selected>
                    No
                </option>

                <option value="1">
                    Yes
                </option>

            </select>

        </div>

    </div>

</div>

    {{-- Product Status --}}
    <div class="grid grid-cols-2 gap-6 mt-6">

        <div>

            <label class="font-medium">
                Product Status
            </label>

            <select
                name="status"
                class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="0">Save as Draft</option>
                <option value="1" selected>Publish</option>

            </select>

        </div>

        <div>

            <label class="font-medium">
                Featured Product
            </label>

            <select
                name="featured"
                class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="0">No</option>
                <option value="1">Yes</option>

            </select>

        </div>

    </div>

    {{-- SEO --}}
    <div class="mt-8 border-t pt-6">

        <h2 class="text-xl font-bold mb-4">
            SEO Settings
        </h2>

        <div class="mb-5">

            <label>Meta Title</label>

            <input
                type="text"
                name="meta_title"
                class="w-full border rounded-lg mt-2 px-4 py-2">

        </div>

        <div class="mb-5">

            <label>Meta Keywords</label>

            <textarea
                name="meta_keywords"
                rows="3"
                class="w-full border rounded-lg mt-2 px-4 py-2"></textarea>

        </div>

        <div>

            <label>Meta Description</label>

            <textarea
                name="meta_description"
                rows="4"
                class="w-full border rounded-lg mt-2 px-4 py-2"></textarea>

        </div>

    </div>

    <div class="mt-8 flex gap-3">

        <button
            type="submit"
            class="bg-gray-700 text-white px-6 py-2 rounded-lg">

            Save Draft

        </button>

        <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg">

            Publish Product

        </button>

    </div>

</form>

    </div>

 <script>
document.addEventListener('DOMContentLoaded', function () {

    const category = document.getElementById('category');
    const sku = document.querySelector('input[name="sku"]');
    const container = document.getElementById('dynamicAttributes');

    if (category) {

        category.addEventListener('change', function () {

    container.innerHTML = '';

    // Auto SKU
    let option = this.options[this.selectedIndex];

    if(option.dataset.prefix){
        sku.value = option.dataset.prefix + '-' + option.dataset.next;
    }

    if (this.value === '') {
        return;
    }

    fetch('/admin/products/category/' + this.value + '/attributes')
                .then(response => response.text())
                .then(html => {

                    container.innerHTML = `
                        <div class="bg-white rounded-lg shadow p-6 mt-6">

                            <h2 class="text-xl font-bold mb-6">
                                Product Specifications
                            </h2>

                            ${html}

                        </div>
                    `;

                    console.log(container.innerHTML);

                })
                .catch(error => {
                    console.error('Error loading attributes:', error);
                });

        });

        // Edit page load
        if (category.value) {
            category.dispatchEvent(new Event('change'));
        }

    }

    function toggleStock() {

        let type = document.getElementById('product_type').value;
        let stock = document.getElementById('stockField');
        let variantSection = document.getElementById('variantSection');

        if (type === 'variable') {
            stock.style.display = 'none';
            variantSection.classList.remove('hidden');
        } else {
            stock.style.display = 'block';
            variantSection.classList.add('hidden');
        }

    }

    toggleStock();

    document
        .getElementById('product_type')
        .addEventListener('change', toggleStock);

    document
        .getElementById('generateVariants')
        ?.addEventListener('click', function () {

            alert('Variant Generator - Next Step');

        });

});
</script>

</x-admin-layout>