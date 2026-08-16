<x-admin-layout>

    <x-slot name="pageTitle">
        Attributes
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Attributes
        </h1>

        <a href="{{ route('attributes.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
            + Add Attribute
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

                    <th class="text-left p-4">ID</th>
                    <th class="text-left p-4">Name</th>
                    <th class="text-left p-4">Slug</th>
                    <th class="text-center p-4">Filterable</th>
                    <th class="text-center p-4">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($attributes as $attribute)

                    <tr class="border-t">

                        <td class="p-4">{{ $attribute->id }}</td>

                        <td class="p-4">{{ $attribute->name }}</td>

                        <td class="p-4">{{ $attribute->slug }}</td>

                        <td class="text-center p-4">
                            {{ $attribute->is_filterable ? '✅' : '❌' }}
                        </td>

                        <td class="p-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('attributes.edit',$attribute->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('attributes.destroy',$attribute->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Delete this attribute?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center p-6">

                            No Attributes Found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-admin-layout>