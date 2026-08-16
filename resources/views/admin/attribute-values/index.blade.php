<x-admin-layout>

    <x-slot name="pageTitle">
        Attribute Values
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Attribute Values
        </h1>

        <a href="{{ route('attribute-values.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
            + Add Value
        </a>

    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Attribute</th>
                    <th class="p-4 text-left">Value</th>
                    <th class="p-4 text-left">Slug</th>
                    <th class="p-4 text-center">Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($values as $value)

                <tr class="border-t">

                    <td class="p-4">{{ $value->id }}</td>

                    <td class="p-4">{{ $value->attribute->name }}</td>

                    <td class="p-4">{{ $value->value }}</td>

                    <td class="p-4">{{ $value->slug }}</td>

                    <td class="p-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('attribute-values.edit',$value->id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded">

                                Edit

                            </a>

                            <form action="{{ route('attribute-values.destroy',$value->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete this value?')"
                                    class="bg-red-600 text-white px-3 py-1 rounded">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center p-6">

                        No Values Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</x-admin-layout>