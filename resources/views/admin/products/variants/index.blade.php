<x-admin-layout>

<x-slot name="pageTitle">
Product Variants
</x-slot>

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            {{ $product->name }}
        </h1>

        <p class="text-gray-500 mt-1">
            Product Variants
        </p>

    </div>

    <div class="flex gap-3">

        <a
            href="{{ route('products.edit',$product) }}"
            class="bg-gray-600 text-white px-4 py-2 rounded">

            ← Product

        </a>

        <a
            href="{{ route('products.variants.create',$product) }}"
            class="bg-blue-600 text-white px-4 py-2 rounded">

            + Add Variant

        </a>

    </div>

</div>

<div class="bg-white rounded-lg shadow">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-3 text-left">SKU</th>

<th class="p-3 text-left">Variant</th>

<th class="p-3 text-left">Price</th>

<th class="p-3 text-left">Stock</th>

<th class="p-3 text-left">Status</th>

<th class="p-3 text-center">Action</th>

</tr>

</thead>

<tbody>

@forelse($variants as $variant)

<tr class="border-t">

<td class="p-3">

{{ $variant->sku }}

</td>

<td class="p-3">

@foreach($variant->values as $value)

<span class="inline-block bg-gray-200 rounded px-2 py-1 mr-2 mb-1">

{{ $value->value->value ?? '-' }}

</span>

@endforeach

</td>

<td class="p-3">

₹{{ number_format($variant->price,2) }}

</td>

<td class="p-3">

{{ $variant->stock }}

</td>

<td class="p-3">

@if($variant->status)

<span class="text-green-600 font-semibold">

Active

</span>

@else

<span class="text-red-600 font-semibold">

Inactive

</span>

@endif

</td>

<td class="p-3 text-center">

<div class="flex justify-center gap-2">

<a
href="{{ route('products.variants.edit',$variant) }}"
class="bg-yellow-500 text-white px-3 py-1 rounded">

Edit

</a>

<form
method="POST"
action="{{ route('products.variants.destroy',$variant) }}">

@csrf
@method('DELETE')

<button
onclick="return confirm('Delete Variant?')"
class="bg-red-600 text-white px-3 py-1 rounded">

Delete

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td
colspan="6"
class="p-8 text-center text-gray-500">

No Variants Found

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</x-admin-layout>