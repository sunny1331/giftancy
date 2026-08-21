<x-admin-layout>

<x-slot name="pageTitle">
Variant Preview
</x-slot>

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            Variant Preview
        </h1>

        <p class="text-gray-500">
            Product: {{ $product->name }}
        </p>

    </div>

    <a
        href="{{ route('products.variants.generate',$product) }}"
        class="bg-gray-600 text-white px-4 py-2 rounded-lg">

        ← Back

    </a>

</div>

<form method="POST"
      action="{{ route('products.variants.storeGenerated', $product) }}">
    @csrf

<div class="bg-white rounded-lg shadow overflow-hidden">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-3 text-left">
Variant
</th>

<th class="p-3">
SKU
</th>

<th class="p-3">
Price
</th>

<th class="p-3">
Stock
</th>

<th class="p-3">
Status
</th>

</tr>

</thead>

<tbody>

@foreach($combinations as $index=>$combo)

<tr class="border-t">

<td class="p-3">

@foreach($combo as $id)

<span class="inline-block bg-gray-200 rounded px-2 py-1 mr-2">

{{ $attributeValues[$id]->value }}

</span>

<input
type="hidden"
name="variants[{{ $index }}][values][]"
value="{{ $id }}">

@endforeach

</td>

<td class="p-3">

<input
type="text"
name="variants[{{ $index }}][sku]"
class="w-full border rounded px-3 py-2"
value="Will be generated automatically"
readonly

</td>

<td class="p-3">

<input
type="number"
step="0.01"
name="variants[{{ $index }}][price]"
class="w-full border rounded px-3 py-2"
value="{{ $product->price }}">

</td>

<td class="p-3">

<input
type="number"
name="variants[{{ $index }}][stock]"
class="w-full border rounded px-3 py-2"
value="0">

</td>

<td class="p-3">

<select
name="variants[{{ $index }}][status]"
class="w-full border rounded px-3 py-2">

<option value="1">
Active
</option>

<option value="0">
Inactive
</option>

</select>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="flex justify-end mt-6">

<button
class="bg-green-600 text-white px-6 py-3 rounded-lg">

Save All Variants

</button>

</div>

</form>

</x-admin-layout>