<x-admin-layout>

    <x-slot name="pageTitle">
        Add Category
    </x-slot>

    <h1 class="text-3xl font-bold mb-6">
        Add Category
    </h1>

    <div class="bg-white rounded-lg shadow p-6">

        <form method="POST"
              action="{{ route('categories.store') }}"
              enctype="multipart/form-data">

            @csrf

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
        value="{{ old('sku_prefix') }}"
        class="w-full border rounded-lg px-4 py-2 uppercase"
        placeholder="Example: FLW, DIY, HDR"
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
                    value="{{ old('name') }}"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Enter Category Name"
                    required
                >

                @error('name')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Category Image
                </label>

                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="w-full border rounded-lg px-4 py-2"
                >

                @error('image')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
            >
                Save Category
            </button>

        </form>

    </div>

</x-admin-layout>