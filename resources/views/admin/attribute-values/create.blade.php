<x-admin-layout>

    <x-slot name="pageTitle">
        Add Attribute Value
    </x-slot>

    <h1 class="text-3xl font-bold mb-6">
        Add Attribute Value
    </h1>

    <div class="bg-white rounded-lg shadow p-6">

        <form method="POST" action="{{ route('attribute-values.store') }}">

            @csrf

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Attribute
                </label>

                <select
                    name="attribute_id"
                    class="w-full border rounded-lg px-4 py-2"
                    required>

                    <option value="">Select Attribute</option>

                    @foreach($attributes as $attribute)

                        <option value="{{ $attribute->id }}">
                            {{ $attribute->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Value
                </label>

                <input
                    type="text"
                    name="value"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Example: Wood"
                    required>

            </div>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                Save Value

            </button>

        </form>

    </div>

</x-admin-layout>