<x-admin-layout>

<x-slot name="pageTitle">
    Edit Product
</x-slot>

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Edit Product
    </h1>

    <a href="{{ route('products.index') }}"
       class="bg-gray-700 text-white px-4 py-2 rounded">

        ← Back

    </a>

</div>

<div class="bg-white rounded-lg shadow p-6">

<form
method="POST"
action="{{ route('products.update',$product->id) }}"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-6">

{{-- Product Name --}}
<div>

<label class="font-medium">

Product Name *

</label>

<input
type="text"
name="name"
value="{{ old('name',$product->name) }}"
class="w-full border rounded-lg mt-2 px-4 py-2"
required>

</div>

<div>

<label class="font-medium">

Product Type

</label>

<select
name="product_type"
id="product_type"
class="w-full border rounded-lg mt-2 px-4 py-2">

<option
value="simple"
{{ $product->product_type=='simple' ? 'selected' : '' }}>

Simple Product

</option>

<option
value="variable"
{{ $product->product_type=='variable' ? 'selected' : '' }}>

Variable Product

</option>

</select>

</div>

{{-- Category --}}
<div>

<label class="font-medium">

Category *

</label>

<select
name="category_id"
class="w-full border rounded-lg mt-2 px-4 py-2">

@foreach($categories as $category)

<option
value="{{ $category->id }}"
{{ $product->category_id==$category->id ? 'selected' : '' }}>

{{ $category->name }}

</option>

@endforeach

</select>

</div>

{{-- SKU --}}
<div>

<label class="font-medium">

SKU

</label>

<input
type="text"
name="sku"
value="{{ old('sku',$product->sku) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

{{-- Selling Price --}}
<div>

<label class="font-medium">

Selling Price

</label>

<input
type="number"
step="0.01"
name="price"
value="{{ old('price',$product->price) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

{{-- Compare Price --}}
<div>

<label class="font-medium">

Compare Price

</label>

<input
type="number"
step="0.01"
name="compare_price"
value="{{ old('compare_price',$product->compare_price) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

{{-- Cost Price --}}
<div>

<label class="font-medium">

Cost Price

</label>

<input
type="number"
step="0.01"
name="cost_price"
value="{{ old('cost_price',$product->cost_price) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

{{-- Stock --}}
<div id="stockField">

<label class="font-medium">

Stock

</label>

<input
type="number"
name="stock"
value="{{ old('stock',$product->stock) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

{{-- Weight --}}
<div>

<label class="font-medium">

Weight

</label>

<input
type="number"
step="0.01"
name="weight"
value="{{ old('weight',$product->weight) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

{{-- Dimensions --}}
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
                value="{{ old('length', $product->length) }}"
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
                value="{{ old('width', $product->width) }}"
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
                value="{{ old('height', $product->height) }}"
                class="w-full border-y border-gray-300 px-3 py-2 focus:outline-none">

            <span class="px-3 border border-l-0 rounded-r-lg bg-gray-100 flex items-center text-sm text-gray-600">
                CM
            </span>

        </div>

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
        rows="8"
        class="w-full border rounded-lg mt-2 px-4 py-2">{{ old('description', $product->description) }}</textarea>

</div>

{{-- Featured Image --}}
<div class="mt-8">

    <label class="font-medium block mb-3">
        Current Featured Image
    </label>

    @if($product->featured_image)

        <img
            src="{{ asset('storage/'.$product->featured_image) }}"
            class="w-40 h-40 object-cover rounded-lg border mb-4">

    @else

        <div class="text-gray-500 mb-4">
            No Featured Image
        </div>

    @endif

    <label class="font-medium block mb-2">
        Change Featured Image
    </label>

    <input
        type="file"
        name="featured_image"
        class="w-full border rounded-lg p-2">

</div>

{{-- Product Gallery --}}
<div class="mt-8">

    <label class="font-medium block mb-4">
        Product Gallery
    </label>

    @if($product->images->count())

        <div class="grid grid-cols-5 gap-4 mb-5">

            @foreach($product->images as $image)

                <div class="border rounded-lg p-2">

    <img
        src="{{ asset('storage/'.$image->image) }}"
        class="w-full h-28 object-cover rounded">

    <button
        type="button"
        class="delete-image mt-2 w-full bg-red-600 text-white rounded py-1"
        data-id="{{ $image->id }}">

        Delete

    </button>

</div>

            @endforeach

        </div>

    @else

        <div class="text-gray-500 mb-4">
            No Gallery Images
        </div>

    @endif

    <label class="font-medium block mb-2">
        Add More Images
    </label>

    <input
        type="file"
        name="gallery[]"
        multiple
        class="w-full border rounded-lg p-2">

</div>

{{-- Dynamic Attributes --}}
<div class="mt-8 border-t pt-6">

    <h2 class="text-xl font-bold mb-5">
        Product Specifications
    </h2>

    <div id="attributeFields">

    </div>

</div>

{{-- SEO Settings --}}
<div class="mt-8 border-t pt-6">

    <h2 class="text-xl font-bold mb-5">
        SEO Settings
    </h2>

    <div class="mb-5">

        <label class="font-medium">
            Meta Title
        </label>

        <input
            type="text"
            name="meta_title"
            value="{{ old('meta_title',$product->meta_title) }}"
            class="w-full border rounded-lg mt-2 px-4 py-2">

    </div>

    <div class="mb-5">

        <label class="font-medium">
            Meta Keywords
        </label>

        <textarea
            name="meta_keywords"
            rows="3"
            class="w-full border rounded-lg mt-2 px-4 py-2">{{ old('meta_keywords',$product->meta_keywords) }}</textarea>

    </div>

    <div>

        <label class="font-medium">
            Meta Description
        </label>

        <textarea
            name="meta_description"
            rows="4"
            class="w-full border rounded-lg mt-2 px-4 py-2">{{ old('meta_description',$product->meta_description) }}</textarea>

    </div>

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

                <option value="1"
                    {{ $product->track_inventory ? 'selected' : '' }}>
                    Yes
                </option>

                <option value="0"
                    {{ !$product->track_inventory ? 'selected' : '' }}>
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

                <option value="in_stock"
                    {{ $product->stock_status=='in_stock' ? 'selected' : '' }}>
                    In Stock
                </option>

                <option value="out_of_stock"
                    {{ $product->stock_status=='out_of_stock' ? 'selected' : '' }}>
                    Out of Stock
                </option>

                <option value="pre_order"
                    {{ $product->stock_status=='pre_order' ? 'selected' : '' }}>
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
                value="{{ old('low_stock_alert',$product->low_stock_alert) }}"
                class="w-full border rounded-lg mt-2 px-4 py-2">

        </div>

        <div>

            <label class="font-medium">
                Continue Selling
            </label>

            <select
                name="continue_selling"
                class="w-full border rounded-lg mt-2 px-4 py-2">

                <option value="0"
                    {{ !$product->continue_selling ? 'selected' : '' }}>
                    No
                </option>

                <option value="1"
                    {{ $product->continue_selling ? 'selected' : '' }}>
                    Yes
                </option>

            </select>

        </div>

    </div>

</div>

{{-- Product Settings --}}
<div class="grid grid-cols-2 gap-6 mt-8">

    <div>

        <label class="font-medium">
            Product Status
        </label>

        <select
            name="status"
            class="w-full border rounded-lg mt-2 px-4 py-2">

            <option
                value="1"
                {{ $product->status ? 'selected' : '' }}>
                Publish
            </option>

            <option
                value="0"
                {{ !$product->status ? 'selected' : '' }}>
                Draft
            </option>

        </select>

    </div>

    <div>

        <label class="font-medium">
            Featured Product
        </label>

        <select
            name="featured"
            class="w-full border rounded-lg mt-2 px-4 py-2">

            <option
                value="0"
                {{ !$product->featured ? 'selected' : '' }}>
                No
            </option>

            <option
                value="1"
                {{ $product->featured ? 'selected' : '' }}>
                Yes
            </option>

        </select>

    </div>

</div>

{{-- Action Buttons --}}
<div class="mt-8 flex items-center gap-4">

    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

        Update Product

    </button>

    <a
        href="{{ route('products.index') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

        Cancel

    </a>

</div>

</form>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    let category = document.querySelector('[name="category_id"]');

    function loadAttributes(categoryId){

    if(!categoryId){
        document.getElementById('attributeFields').innerHTML='';
        return;
    }

    fetch(`/admin/products/category/${categoryId}/attributes?product_id={{ $product->id }}`)

        .then(response => response.text())

        .then(html => {

            document.getElementById('attributeFields').innerHTML = html;

        })

        .catch(error => {

            console.error(error);

        });

}

    loadAttributes(category.value);

    category.addEventListener('change',function(){

        loadAttributes(this.value);

    });

});

document.querySelectorAll('.delete-image').forEach(function(button){

    button.addEventListener('click',function(){

        if(!confirm('Delete this image?')){
            return;
        }

        fetch('/admin/product-images/'+this.dataset.id,{

            method:'DELETE',

            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}',
                'Accept':'application/json'
            }

        })

        .then(res=>res.json())

        .then(data=>{

            if(data.success){

                this.parentElement.remove();

            }

        });

    });

});

function toggleStock(){

    let type = document.getElementById('product_type').value;

    let stock = document.getElementById('stockField');

    if(type === 'variable'){

        stock.style.display = 'none';

    }else{

        stock.style.display = 'block';

    }

}

toggleStock();

document
.getElementById('product_type')
.addEventListener('change', toggleStock);

</script>

</x-admin-layout>