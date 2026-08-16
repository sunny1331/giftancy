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

        {{-- Category --}}
        <div>
            <label class="font-medium">Category *</label>

            <select
    name="category_id"
    id="category"
    class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="">Select Category</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
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
        <div>
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

    <input
        type="text"
        name="dimensions"
        class="w-full border rounded-lg px-4 py-2"
        placeholder="20 x 15 x 30 cm">
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
    const container = document.getElementById('dynamicAttributes');

    category.addEventListener('change', function () {

        container.innerHTML = '';

        if (this.value == '') {
            return;
        }

        fetch('/admin/products/category/' + this.value + '/attributes')

        .then(response => response.json())

        .then(attributes => {

            let html = '<div class="bg-white rounded-lg shadow p-6 mt-6">';
            html += '<h2 class="text-xl font-bold mb-6">Product Attributes</h2>';
            html += '<div class="grid grid-cols-2 gap-6">';

            attributes.forEach(attribute => {

                let field='';

field='';

switch(attribute.field_type){

case 'dropdown':

field=`<select
name="attributes[${attribute.id}]"
class="w-full border rounded-lg px-4 py-2">

<option value="">Select ${attribute.name}</option>

${
attribute.values.map(value=>`
<option value="${value.id}">
${value.value}
</option>
`).join('')
}

</select>`;

break;

case 'textarea':

field=`<textarea
name="attributes[${attribute.id}]"
class="w-full border rounded-lg px-4 py-2"
rows="3"></textarea>`;

break;

case 'number':

field=`<input
type="number"
name="attributes[${attribute.id}]"
class="w-full border rounded-lg px-4 py-2">`;

break;

case 'date':

field=`<input
type="date"
name="attributes[${attribute.id}]"
class="w-full border rounded-lg px-4 py-2">`;

break;

case 'boolean':

field=`<select
name="attributes[${attribute.id}]"
class="w-full border rounded-lg px-4 py-2">

<option value="1">Yes</option>
<option value="0">No</option>

</select>`;

break;

default:

field=`<input
type="text"
name="attributes[${attribute.id}]"
class="w-full border rounded-lg px-4 py-2"
placeholder="${attribute.name}">`;

}

html+=`
<div class="mb-5">

<label class="block mb-2 font-medium">
${attribute.name}
</label>

${field}

</div>
`;

            });

            html += '</div>';
            html += '</div>';

            container.innerHTML = html;

        });

    });

});

document
.getElementById('generateVariants')
?.addEventListener('click',function(){

    alert('Variant Generator - Next Step');

});

</script>

</x-admin-layout>