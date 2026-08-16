<x-admin-layout>

    <x-slot name="pageTitle">
        Edit Attribute
    </x-slot>

    <h1 class="text-3xl font-bold mb-6">
        Edit Attribute
    </h1>

    <div class="bg-white rounded-lg shadow p-6">

        <form method="POST" action="{{ route('attributes.update', $attribute->id) }}">

            @csrf
            @method('PUT')

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Attribute Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $attribute->name) }}"
                    class="w-full border rounded-lg px-4 py-2"
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

                    <option value="dropdown" {{ $attribute->field_type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                    <option value="text" {{ $attribute->field_type == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="textarea" {{ $attribute->field_type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                    <option value="number" {{ $attribute->field_type == 'number' ? 'selected' : '' }}>Number</option>
                    <option value="boolean" {{ $attribute->field_type == 'boolean' ? 'selected' : '' }}>Yes / No</option>
                    <option value="color" {{ $attribute->field_type == 'color' ? 'selected' : '' }}>Color Picker</option>
                    <option value="date" {{ $attribute->field_type == 'date' ? 'selected' : '' }}>Date</option>
                    <option value="multiselect" {{ $attribute->field_type == 'multiselect' ? 'selected' : '' }}>Multi Select</option>

                </select>

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Attribute Group
                </label>

                <select
                    name="group_name"
                    class="w-full border rounded-lg px-4 py-2">

                    <option value="General" {{ $attribute->group_name == 'General' ? 'selected' : '' }}>General</option>
                    <option value="Basic Information" {{ $attribute->group_name == 'Basic Information' ? 'selected' : '' }}>Basic Information</option>
                    <option value="Specifications" {{ $attribute->group_name == 'Specifications' ? 'selected' : '' }}>Specifications</option>
                    <option value="Package" {{ $attribute->group_name == 'Package' ? 'selected' : '' }}>Package</option>
                    <option value="Shipping" {{ $attribute->group_name == 'Shipping' ? 'selected' : '' }}>Shipping</option>
                    <option value="Warranty" {{ $attribute->group_name == 'Warranty' ? 'selected' : '' }}>Warranty</option>

                </select>

            </div>

            <div class="mb-5">

                <label class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="is_filterable"
                        value="1"
                        {{ $attribute->is_filterable ? 'checked' : '' }}
                    >

                    <span>Use this attribute in Product Filters</span>

                </label>

            </div>

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg"
            >
                Update Attribute
            </button>

        </form>

    </div>

</x-admin-layout>