<x-admin-layout>

<x-slot name="pageTitle">
Add Variant
</x-slot>

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Add Variant
    </h1>

    <a
        href="{{ route('products.variants.index',$product) }}"
        class="bg-gray-600 text-white px-4 py-2 rounded">

        ← Back

    </a>

</div>

<form
method="POST"
action="{{ route('products.variants.store',$product) }}"
enctype="multipart/form-data">

@csrf

@if ($errors->has('duplicate'))

<div class="mb-5 bg-red-100 text-red-700 p-4 rounded">

{{ $errors->first('duplicate') }}

</div>

@endif

<div class="bg-white rounded-lg shadow p-6">

<div class="grid grid-cols-2 gap-6">

<div>

<label class="font-medium">

SKU

</label>

<input
    type="text"
    class="w-full border rounded-lg px-4 py-2 bg-gray-100"
    value="{{ $nextSku }}"
    readonly>

</div>

<div>

<label class="font-medium">

Price

</label>

<input
type="number"
step="0.01"
name="price"
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
class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

<div>

<label class="font-medium">

Stock

</label>

<input
type="number"
name="stock"
value="0"
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
        class="w-full border rounded-lg mt-2 px-4 py-2">

</div>

{{-- Status --}}
<div>

    <label class="font-medium">
        Status
    </label>

    <select
        name="status"
        class="w-full border rounded-lg mt-2 px-4 py-2">

        <option value="1" selected>
            Active
        </option>

        <option value="0">
            Inactive
        </option>

    </select>

</div>

</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">

    <p class="text-blue-700">
        📷 Variant images can be uploaded after creating the variant.
    </p>

</div>

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

<option value="{{ $value->id }}">

{{ $value->value }}

</option>

@endforeach

</select>

</div>

@endforeach

</div>

<div class="mt-8">

<button
class="bg-blue-600 text-white px-6 py-3 rounded">

Save Variant

</button>

</div>

</div>

</form>

</x-admin-layout>