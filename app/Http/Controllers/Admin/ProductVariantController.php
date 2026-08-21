<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariantValue;
use App\Models\ProductVariantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
   public function index(Product $product)
{
    $variants = $product->variants()
        ->with([
            'values.value',
            'primaryImage'
        ])
        ->latest()
        ->get();

    return view(
        'admin.products.variants.index',
        compact('product', 'variants')
    );
}

public function generate(Product $product)
{
    $attributes = Attribute::with('values')
        ->whereHas('categories', function ($q) use ($product) {
            $q->where('categories.id', $product->category_id);
        })
        ->get();

    return view(
        'admin.products.variants.generate',
        compact('product', 'attributes')
    );
}

public function preview(Request $request, Product $product)
{
    if ($request->isMethod('post')) {

        $attributes = $request->input('attributes', []);

        $groups = [];

        foreach ($attributes as $attributeId => $values) {

            if (!empty($values)) {
                $groups[] = $values;
            }

        }

        if (count($groups) == 0) {

            return back()->with(
                'error',
                'Please select at least one attribute.'
            );

        }

        $combinations = [[]];

        foreach ($groups as $group) {

            $tmp = [];

            foreach ($combinations as $combination) {

                foreach ($group as $value) {

                    $tmp[] = array_merge(
                        $combination,
                        [$value]
                    );

                }

            }

            $combinations = $tmp;

        }

        session([
            'variant_preview_'.$product->id => $combinations
        ]);

        return redirect()->route(
            'products.variants.preview',
            $product
        );

    }

    $combinations = session(
        'variant_preview_'.$product->id
    );

    if (!$combinations) {

        return redirect()
            ->route(
                'products.variants.generate',
                $product
            )
            ->with(
                'error',
                'Please generate variants first.'
            );

    }

    $attributeValues = AttributeValue::whereIn(
        'id',
        collect($combinations)->flatten()
    )->get()->keyBy('id');

    return view(
        'admin.products.variants.preview',
        compact(
            'product',
            'combinations',
            'attributeValues'
        )
    );
}

public function storeGenerated(Request $request, Product $product)
{
    DB::beginTransaction();

    try {

        $created = 0;
        $skipped = 0;

        foreach ($request->variants as $variantData) {

            /*
            |--------------------------------------------------------------------------
            | Duplicate Combination Check
            |--------------------------------------------------------------------------
            */

            $selectedValues = collect($variantData['values'])
                ->sort()
                ->values()
                ->toArray();

            $exists = ProductVariant::where('product_id', $product->id)
                ->with('values')
                ->get()
                ->first(function ($variant) use ($selectedValues) {

                    return $variant->values
                        ->pluck('attribute_value_id')
                        ->sort()
                        ->values()
                        ->toArray() == $selectedValues;

                });

            if ($exists) {
                $skipped++;
                continue;
            }

/*
|--------------------------------------------------------------------------
| Auto Variant SKU
|--------------------------------------------------------------------------
*/

$sku = $product->sku . '-' .
    str_pad(
        $product->next_variant_number,
        3,
        '0',
        STR_PAD_LEFT
    );

$product->increment('next_variant_number');


            /*
            |--------------------------------------------------------------------------
            | Create Variant
            |--------------------------------------------------------------------------
            */

            $variant = ProductVariant::create([

                'product_id'     => $product->id,
                'sku'            => $sku,
                'price'          => $variantData['price'],
                'compare_price'  => null,
                'stock'          => $variantData['stock'],
                'weight'         => 0,
                'image'          => null,
                'status'         => $variantData['status'],

            ]);

            foreach ($variantData['values'] as $valueId) {

                $attributeValue = AttributeValue::find($valueId);

                ProductVariantValue::create([

                    'product_variant_id' => $variant->id,
                    'attribute_id'       => $attributeValue->attribute_id,
                    'attribute_value_id' => $valueId,

                ]);

            }

            $created++;

        }

        DB::commit();

        session()->forget('variant_preview_' . $product->id);

        return redirect()
            ->route('products.variants.index', $product)
            ->with(
                'success',
                "{$created} variants created successfully. {$skipped} variants were skipped because they already exist."
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->withErrors([
                'error' => $e->getMessage()
            ]);

    }
}

    public function create(Product $product)
{
    $attributes = Attribute::with('values')
    ->whereHas('categories', function ($q) use ($product) {
        $q->where('categories.id', $product->category_id);
    })
    ->get();

    $lastVariant = $product->variants()->latest('id')->first();

if ($lastVariant) {

    $lastNumber = (int) substr($lastVariant->sku, -3);

    $nextSku = $product->sku . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

} else {

    $nextSku = $product->sku . '-001';

}

    return view(
    'admin.products.variants.create',
    compact(
        'product',
        'attributes',
        'nextSku'
    )
);
}

    public function store(Request $request, Product $product)
{
    $request->validate([

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

$product->refresh();

$variantCount = ProductVariant::where('product_id', $product->id)->count() + 1;

$sku = $product->sku . '-' . str_pad($variantCount, 3, '0', STR_PAD_LEFT);

// Safety
while (ProductVariant::where('sku', $sku)->exists()) {

    $variantCount++;

    $sku = $product->sku . '-' . str_pad($variantCount, 3, '0', STR_PAD_LEFT);

}

    $variant = ProductVariant::create([

        'product_id'=>$product->id,

        'sku'=>$sku,

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

    public function images(ProductVariant $variant)
{
    $variant->load(
        'images',
        'values.value'
    );

    return view(
        'admin.products.variants.images',
        compact('variant')
    );
}

public function uploadImages(Request $request, ProductVariant $variant)
{
    $request->validate([
        'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096'
    ]);

    if ($request->hasFile('images')) {

        foreach ($request->file('images') as $index => $image) {

            ProductVariantImage::create([

                'product_variant_id' => $variant->id,

                'image' => $image->store(
                    'variants',
                    'public'
                ),

                'sort_order' => $index,

                'is_primary' => $variant->images()->count() == 0

            ]);

        }

    }

    return back()->with(
        'success',
        'Images Uploaded Successfully.'
    );
}

public function primaryImage(ProductVariantImage $image)
{
    ProductVariantImage::where(
        'product_variant_id',
        $image->product_variant_id
    )->update([
        'is_primary' => false
    ]);

    $image->update([
        'is_primary' => true
    ]);

    return back()->with(
        'success',
        'Primary Image Updated.'
    );
}

public function deleteImage(ProductVariantImage $image)
{
    Storage::disk('public')->delete($image->image);

    $image->delete();

    return back()->with(
        'success',
        'Image Deleted Successfully.'
    );
}

}