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

        <a
href="{{ route('products.variants.generate',$product) }}"
class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">

⚡ Generate Variants

</a>

    </div>

</div>

<div class="bg-white rounded-lg shadow">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-3 text-left">Image</th>

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

@if($variant->primaryImage)

<img
    src="{{ asset('storage/'.$variant->primaryImage->image) }}"
    class="w-14 h-14 rounded-lg border object-cover">

@else

<div class="w-14 h-14 rounded-lg border bg-gray-100 flex items-center justify-center text-gray-400">

No Image

</div>

@endif

</td>

<td class="p-3">

{{ $variant->sku }}

</td>

<td class="p-3">

@foreach($variant->values as $item)

<div class="mb-1">

    <span class="font-semibold">

        {{ $item->attribute->name ?? '-' }} :

    </span>

    <span class="bg-gray-100 px-2 py-1 rounded">

        {{ $item->value->value ?? '-' }}

    </span>

</div>

@endforeach

</td>

<td class="p-3">

<div class="font-semibold text-gray-900">

₹{{ number_format($variant->price,2) }}

</div>

@if($variant->compare_price)

<div class="text-sm text-gray-500 line-through">

₹{{ number_format($variant->compare_price,2) }}

</div>

@endif

</td>

<td class="p-3">

@if($variant->stock > 10)

<span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">

🟢 {{ $variant->stock }} In Stock

</span>

@elseif($variant->stock > 0)

<span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">

🟡 {{ $variant->stock }} Low Stock

</span>

@else

<span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">

🔴 Out of Stock

</span>

@endif

</td>

<td class="p-3">

@if($variant->status)

<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">

    🟢 Active

</span>

@else

<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">

    🔴 Inactive

</span>

@endif

</td>

<td class="p-3">

<div class="flex justify-center items-center gap-2">

<a
href="{{ route('products.variants.edit',$variant) }}"
class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">

✏️ Edit

</a>

<a
href="{{ route('variants.images',$variant) }}"
class="bg-indigo-600 text-white px-3 py-1 rounded">

Images

</a>

<form
method="POST"
action="{{ route('products.variants.destroy',$variant) }}"
onsubmit="return confirm('Are you sure you want to delete this variant?');">

@csrf
@method('DELETE')

<button
type="submit"
class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">

🗑 Delete

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td
colspan="7"
class="p-8 text-center text-gray-500">

No Variants Found

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</x-admin-layout>