<x-admin-layout>

<x-slot name="pageTitle">
Generate Variants
</x-slot>

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            Generate Variants
        </h1>

        <p class="text-gray-500">
            Product: {{ $product->name }}
        </p>

    </div>

    <a
        href="{{ route('products.variants.index',$product) }}"
        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">

        ← Back

    </a>

</div>


<form
    method="POST"
    action="{{ route('products.variants.preview',$product) }}"

    @csrf

    <div class="bg-white rounded-lg shadow p-6">

        @foreach($attributes as $attribute)

        <div class="mb-8 attribute-group">

            <h2 class="text-lg font-bold mb-4">
                {{ $attribute->name }}
            </h2>

            <div class="flex flex-wrap gap-3">

                @foreach($attribute->values as $value)

                <label
                    class="variant-option inline-flex items-center gap-3 border border-gray-300 rounded-lg px-4 py-3 cursor-pointer transition hover:bg-blue-50 hover:border-blue-500">

                    <input
                        type="checkbox"
                        name="attributes[{{ $attribute->id }}][]"
                        value="{{ $value->id }}"
                        class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                    <span class="font-medium text-gray-700">
                        {{ $value->value }}
                    </span>

                </label>

                @endforeach

            </div>

        </div>

        @endforeach

        <hr class="my-6">

        <div class="flex justify-between items-center border-t pt-6">

            <div class="bg-blue-50 border border-blue-200 rounded-lg px-6 py-4">

                <p class="text-lg font-semibold">

                    Total Variants:
                    <span id="variantCount" class="text-blue-600">
                        0
                    </span>

                </p>

            </div>

            <button
                id="generateBtn"
                type="submit"
                disabled
                class="bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-3 rounded-lg font-semibold transition">

                ⚡ Generate 0 Variants

            </button>

        </div>

    </div>

</form>

<script>

function updateVariantCount() {

    let total = 1;

    document.querySelectorAll('.attribute-group').forEach(group => {

        let checked = group.querySelectorAll(
            'input[type="checkbox"]:checked'
        ).length;

        if (checked > 0) {
            total *= checked;
        }

    });

    if (document.querySelectorAll('input[type="checkbox"]:checked').length == 0) {
        total = 0;
    }

    document.getElementById('variantCount').innerText = total;

    let btn = document.getElementById('generateBtn');

    btn.innerText = `⚡ Generate ${total} Variants`;

    btn.disabled = total == 0;

}

document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {

    checkbox.addEventListener('change', function () {

        let label = this.closest('label');

        if (this.checked) {

            label.classList.add(
                'bg-blue-50',
                'border-blue-500'
            );

        } else {

            label.classList.remove(
                'bg-blue-50',
                'border-blue-500'
            );

        }

        updateVariantCount();

    });

});

updateVariantCount();

</script>

</x-admin-layout>