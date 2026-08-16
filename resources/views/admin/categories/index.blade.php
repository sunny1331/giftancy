<x-admin-layout>

    <x-slot name="pageTitle">
        Categories
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Categories
        </h1>

        <a href="{{ route('categories.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Category
        </a>

    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded shadow">

        <table class="w-full">

            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-4">ID</th>
                    <th class="text-left p-4">Name</th>
                    <th class="text-left p-4">Slug</th>
                    <th class="text-left p-4">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr class="border-t">

                        <td class="p-4">{{ $category->id }}</td>

                        <td class="p-4">{{ $category->name }}</td>

                        <td class="p-4">{{ $category->slug }}</td>

                        <td class="p-4">

                            <div class="flex gap-2">

                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <a href="{{ route('categories.attributes',$category->id) }}"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">

Attributes

</a>

                                <form action="{{ route('categories.destroy', $category->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('Delete this category?')"
                                            class="bg-red-600 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center p-6">
                            No Categories Found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-admin-layout>