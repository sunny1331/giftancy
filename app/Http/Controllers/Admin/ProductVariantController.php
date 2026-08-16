<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariantValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductVariantController extends Controller
{
    public function index(Product $product)
{
    $variants = $product->variants()
        ->with('values.value')
        ->latest()
        ->get();

    return view(
        'admin.products.variants.index',
        compact('product', 'variants')
    );
}

    public function create(Product $product)
{
    $attributes = Attribute::with('values')
    ->whereHas('categories', function ($q) use ($product) {
        $q->where('categories.id', $product->category_id);
    })
    ->get();

    return view(
        'admin.products.variants.create',
        compact('product', 'attributes')
    );
}

    public function store(Request $request, Product $product)
{
    $request->validate([

        'sku'=>'required|unique:product_variants',

        'price'=>'required|numeric',

        'compare_price'=>'nullable|numeric',

        'stock'=>'nullable|integer',

        'weight'=>'nullable|numeric',

        'status'=>'required',

        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

    ]);

    $selectedValues = array_filter(
    $request->input('attributes', [])
);

sort($selectedValues);

$existingVariants = ProductVariant::where(
    'product_id',
    $product->id
)->with('values')->get();

foreach ($existingVariants as $existing) {

    $existingValues = $existing->values
    ->pluck('attribute_value_id')
        ->sort()
        ->values()
        ->toArray();

    if ($existingValues == array_values($selectedValues)) {

        return back()
            ->withInput()
            ->withErrors([
                'duplicate' => 'This variant already exists.'
            ]);

    }
}

$image = null;

if ($request->hasFile('image')) {

    $image = $request
        ->file('image')
        ->store(
            'variants',
            'public'
        );

}

    $variant = ProductVariant::create([

        'product_id'=>$product->id,

        'sku'=>$request->sku,

        'price'=>$request->price,

        'compare_price'=>$request->compare_price,

        'stock'=>$request->stock,

        'weight'=>$request->weight,

        'status'=>$request->status,

        'image' => $image,

    ]);

    if ($request->filled('attributes')) {

    foreach ($request->input('attributes', []) as $attribute => $value) {

            if(empty($value)){
                continue;
            }

            ProductVariantValue::create([
    'product_variant_id' => $variant->id,
    'attribute_id' => $attribute,
    'attribute_value_id' => $value,
]);

        }

    }

    return redirect()
        ->route(
            'products.variants.index',
            $product
        )
        ->with(
            'success',
            'Variant Added Successfully.'
        );
}

    public function edit(ProductVariant $variant)
{
    $variant->load('values');

    $product = $variant->product;

    $attributes = Attribute::with('values')
        ->whereHas('categories', function ($q) use ($product) {
           $q->where('categories.id', $product->category_id);
        })
        ->get();

    $selected = $variant->values
        ->pluck(
    'attribute_value_id',
    'attribute_id'
)
        ->toArray();

    return view(
        'admin.products.variants.edit',
        compact(
            'variant',
            'product',
            'attributes',
            'selected'
        )
    );
}

    public function update(Request $request, ProductVariant $variant)
{
    $request->validate([

        'sku' => 'required|unique:product_variants,sku,' . $variant->id,

        'price' => 'required|numeric',

        'compare_price' => 'nullable|numeric',

        'stock' => 'nullable|integer',

        'weight' => 'nullable|numeric',

        'status' => 'required',

    ]);

    if ($request->hasFile('image')) {

    if ($variant->image) {

        \Storage::disk('public')->delete($variant->image);

    }

    $variant->image = $request
        ->file('image')
        ->store('variants', 'public');

}

    $variant->update([

        'sku' => $request->sku,

        'price' => $request->price,

        'compare_price' => $request->compare_price,

        'stock' => $request->stock,

        'weight' => $request->weight,

        'status' => $request->status,

        'image' => $variant->image,

    ]);

    $variant->values()->delete();

    if ($request->filled('attributes')) {

    foreach ($request->input('attributes', []) as $attribute => $value) {

            if (empty($value)) {
                continue;
            }

            ProductVariantValue::create([
    'product_variant_id' => $variant->id,
    'attribute_id' => $attribute,
    'attribute_value_id' => $value,
]);

        }

    }

    return redirect()
        ->route(
            'products.variants.index',
            $variant->product
        )
        ->with(
            'success',
            'Variant Updated Successfully.'
        );
}

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();

        return back()->with(
            'success',
            'Variant Deleted Successfully.'
        );
    }
}