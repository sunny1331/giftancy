<x-admin-layout>

    <x-slot name="pageTitle">
        Add Attribute
    </x-slot>

    <h1 class="text-3xl font-bold mb-6">
        Add Attribute
    </h1>

    <div class="bg-white rounded-lg shadow p-6">

        <form method="POST" action="{{ route('attributes.store') }}">

            @csrf

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Attribute Name
                </label>

                <input
                    type="text"
                    name="name"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Example: Material"
                    required
                >

            </div>

            <div class="mb-5">

    <label class="block mb-2 font-medium">
        Field Type
    </label>

    <select
        name="field_type"
        class="w-full border rounded-lg px-4 py-2">

        <option value="dropdown">Dropdown</option>
        <option value="text">Text</option>
        <option value="textarea">Textarea</option>
        <option value="number">Number</option>
        <option value="boolean">Yes / No</option>
        <option value="color">Color Picker</option>
        <option value="date">Date</option>
        <option value="multiselect">Multi Select</option>

    </select>

</div>

<div class="mb-5">

    <label class="block mb-2 font-medium">

        Attribute Group

    </label>

    <select
        name="group_name"
        class="w-full border rounded-lg px-4 py-2">

        <option value="General">General</option>
        <option value="Basic Information">Basic Information</option>
        <option value="Specifications">Specifications</option>
        <option value="Package">Package</option>
        <option value="Shipping">Shipping</option>
        <option value="Warranty">Warranty</option>

    </select>

</div>

            <div class="mb-5">

                <label class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="is_filterable"
                        checked
                    >

                    <span>Use this attribute in Product Filters</span>

                </label>

            </div>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
            >
                Save Attribute
            </button>

        </form>

    </div>

</x-admin-layout>