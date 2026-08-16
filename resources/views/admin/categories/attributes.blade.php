<x-admin-layout>

<x-slot name="pageTitle">
Assign Attributes
</x-slot>

<h1 class="text-3xl font-bold mb-6">

{{ $category->name }}

</h1>

@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded mb-6">

{{ session('success') }}

</div>

@endif

<form
method="POST"
action="{{ route('categories.attributes.store',$category->id) }}">

@csrf

<div class="bg-white rounded-lg shadow p-6">

<div class="grid grid-cols-2 gap-4">

@foreach($attributes as $attribute)

<label
class="flex items-center gap-3 border rounded p-3">

<input
type="checkbox"
name="attributes[]"
value="{{ $attribute->id }}"
{{ in_array($attribute->id,$selected) ? 'checked' : '' }}>

<span>

{{ $attribute->name }}

</span>

</label>

@endforeach

</div>

<button
class="mt-6 bg-blue-600 text-white px-6 py-2 rounded">

Save

</button>

</div>

</form>

</x-admin-layout>