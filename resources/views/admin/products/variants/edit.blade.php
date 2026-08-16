<x-admin-layout>

<x-slot name="pageTitle">
Edit Variant
</x-slot>

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Edit Variant
    </h1>

    <a
        href="{{ route('products.variants.index',$product) }}"
        class="bg-gray-600 text-white px-4 py-2 rounded">

        ← Back

    </a>

</div>

<form
method="POST"
action="{{ route('products.variants.update',$variant) }}"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="bg-white rounded-lg shadow p-6">

<div class="grid grid-cols-2 gap-6">

<div>

<label class="font-medium">

SKU

</label>

<input
type="text"
name="sku"
value="{{ old('sku',$variant->sku) }}"
class="w-full border rounded-lg mt-2 px-4 py-2"
required>

</div>

<div>

<label class="font-medium">

Price

</label>

<input
type="number"
step="0.01"
name="price"
value="{{ old('price',$variant->price) }}"
class="w-full border rounded-lg mt-2 px-4 py-2"
required>

</div>

<div>

<label class="font-medium">

Compare Price

</label>

<input
type="number"
step="0.01"
name="compare_price"
value="{{ old('compare_price',$variant->compare_price) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

<div>

<label class="font-medium">

Stock

</label>

<input
type="number"
name="stock"
value="{{ old('stock',$variant->stock) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

<div>

<label class="font-medium">

Weight

</label>

<input
type="number"
step="0.01"
name="weight"
value="{{ old('weight',$variant->weight) }}"
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

<div>

<label class="font-medium">

Status

</label>

<select
name="status"
class="w-full border rounded-lg mt-2 px-4 py-2">

<option value="1" {{ $variant->status ? 'selected' : '' }}>
Active
</option>

<option value="0" {{ !$variant->status ? 'selected' : '' }}>
Inactive
</option>

</select>

</div>

</div>

<hr class="my-8">

<h2 class="text-xl font-bold mb-5">
Variant Image
</h2>

@if($variant->image)

<img
    src="{{ asset('storage/'.$variant->image) }}"
    class="w-40 h-40 object-cover rounded-lg border mb-4">

@endif

<input
    type="file"
    name="image"
    class="w-full border rounded-lg p-2">

<hr class="my-8">

<h2 class="text-xl font-bold mb-5">

Variant Attributes

</h2>

<div class="grid grid-cols-2 gap-6">

@foreach($attributes as $attribute)

<div>

<label class="font-medium">

{{ $attribute->name }}

</label>

<select
name="attributes[{{ $attribute->id }}]"
class="w-full border rounded-lg mt-2 px-4 py-2">

<option value="">
Select {{ $attribute->name }}
</option>

@foreach($attribute->values as $value)

<option
value="{{ $value->id }}"
{{ (isset($selected[$attribute->id]) && $selected[$attribute->id]==$value->id) ? 'selected' : '' }}>

{{ $value->value }}

</option>

@endforeach

</select>

</div>

@endforeach

</div>

<div class="mt-8">

<button
class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

Update Variant

</button>

</div>

</div>

</form>

</x-admin-layout>