<div class="grid grid-cols-2 gap-6">

@foreach($attributes as $attribute)

<div class="mb-5">

    <label class="block mb-2 font-medium">

        {{ $attribute->name }}

    </label>

    @if($attribute->field_type == 'dropdown')

        <select
            name="attributes[{{ $attribute->id }}]"
            class="w-full border rounded-lg px-4 py-2">

            <option value="">
                Select {{ $attribute->name }}
            </option>

            @foreach($attribute->values as $value)

                <option
    value="{{ $value->id }}"
    {{ (isset($selected[$attribute->id]) && $selected[$attribute->id] == $value->id) ? 'selected' : '' }}>

                    {{ $value->value }}

                </option>

            @endforeach

        </select>

    @elseif($attribute->field_type == 'text')

        <input
    type="text"
    name="attributes[{{ $attribute->id }}]"
    value="{{ old('attributes.'.$attribute->id, $selected[$attribute->id] ?? '') }}"
    class="w-full border rounded-lg px-4 py-2">
    @elseif($attribute->field_type == 'textarea')

        <textarea
    name="attributes[{{ $attribute->id }}]"
    class="w-full border rounded-lg px-4 py-2"
    rows="3">{{ old('attributes.'.$attribute->id, $selected[$attribute->id] ?? '') }}</textarea>

    @endif

</div>

@endforeach

</div>