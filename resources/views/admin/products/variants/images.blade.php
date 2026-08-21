<x-admin-layout>

<x-slot name="pageTitle">
Variant Images
</x-slot>

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            Variant Images
        </h1>

        <p class="text-gray-500 mt-2">

            SKU :
            <strong>{{ $variant->sku }}</strong>

        </p>

    </div>

    <a href="{{ route('products.variants.index',$variant->product) }}"
       class="bg-gray-700 text-white px-5 py-2 rounded">

        ← Back

    </a>

</div>

@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded mb-5">

    {{ session('success') }}

</div>

@endif

<form method="POST"
      action="{{ route('variants.images.upload',$variant) }}"
      enctype="multipart/form-data">

    @csrf

    <div class="bg-white rounded-lg shadow p-6">

        <label class="font-medium">

            Upload Images

        </label>

        <input
            type="file"
            name="images[]"
            multiple
            accept="image/*"
            class="w-full border rounded mt-3 p-2">

        <button
            class="mt-4 bg-blue-600 text-white px-5 py-2 rounded">

            Upload Images

        </button>

    </div>

</form>

<div class="grid grid-cols-4 gap-6 mt-8">

@foreach($variant->images as $image)

<div class="bg-white rounded shadow p-3">

<img
src="{{ asset('storage/'.$image->image) }}"
class="w-full h-48 object-cover rounded">

<div class="mt-4 flex justify-between">

<form
method="POST"
action="{{ route('variants.images.primary',$image) }}">

@csrf

<button
class="text-blue-600 text-sm">

@if($image->is_primary)

⭐ Primary

@else

Set Primary

@endif

</button>

</form>

<form
method="POST"
action="{{ route('variants.images.delete',$image) }}">

@csrf
@method('DELETE')

<button
onclick="return confirm('Delete Image?')"
class="text-red-600 text-sm">

Delete

</button>

</form>

</div>

</div>

@endforeach

</div>

</x-admin-layout>