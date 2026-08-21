<x-admin-layout>

    <x-slot name="pageTitle">
        Edit Category
    </x-slot>

    <h1 class="text-3xl font-bold mb-6">
        Edit Category
    </h1>

    <div class="bg-white rounded-lg shadow p-6">

        <form method="POST" action="{{ route('categories.update',$category->id) }}">

            @csrf
            @method('PUT')

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Category Name
                </label>

                <div class="mb-5">

    <label class="block mb-2 font-medium">
        SKU Prefix
    </label>

    <input
        type="text"
        name="sku_prefix"
        value="{{ old('sku_prefix', $category->sku_prefix) }}"
        class="w-full border rounded-lg px-4 py-2 uppercase"
        placeholder="Example: FLW"
        maxlength="10"
        required
    >

    <p class="text-gray-500 text-sm mt-2">
        Example: FLW = Flowers, DIY = Do It Yourself
    </p>

    @error('sku_prefix')
        <p class="text-red-600 text-sm mt-2">
            {{ $message }}
        </p>
    @enderror

</div>

                <input
                    type="text"
                    name="name"
                    value="{{ $category->name }}"
                    class="w-full border rounded-lg px-4 py-2"
                    required
                >

            </div>

            <button
                type="submit"
                class="bg-green-600 text-white px-5 py-2 rounded-lg"
            >
                Update Category
            </button>

        </form>

    </div>

</x-admin-layout>