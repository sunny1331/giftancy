<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Attribute;
use App\Models\ProductAttributeData;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
{
    $categories = \App\Models\Category::orderBy('name')->get();

    return view('admin.products.create', compact('categories'));
}

    public function store(Request $request)
{
    $request->validate([

    'category_id' => 'required|exists:categories,id',

    'name' => 'required|max:255',

    'price' => 'required|numeric',

    'compare_price' => 'nullable|numeric',

    'cost_price' => 'nullable|numeric',

    'stock' => 'nullable|integer',

    'weight' => 'nullable|numeric',

    'length' => 'nullable|numeric',

    'width' => 'nullable|numeric',

    'height' => 'nullable|numeric',

    'description' => 'nullable',

    'meta_title' => 'nullable|string|max:255',

    'meta_keywords' => 'nullable',

    'meta_description' => 'nullable',

    'status' => 'required|boolean',

    'featured' => 'required|boolean',

    'product_type' => 'required|in:simple,variable',

    'track_inventory' => 'required|boolean',

    'low_stock_alert' => 'required|integer|min:0',

    'continue_selling' => 'required|boolean',

    'stock_status' => 'required|in:in_stock,out_of_stock,pre_order',

    'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

    'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

]);

$featuredImage = null;

if ($request->hasFile('featured_image')) {

    $featuredImage = $request
        ->file('featured_image')
        ->store('products', 'public');

}

   DB::transaction(function () use ($request, $featuredImage) {

    $category = Category::lockForUpdate()->findOrFail($request->category_id);

$prefix = strtoupper($category->sku_prefix);

if (empty($prefix)) {
    $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $category->name), 0, 3));
}

$sku = $prefix . '-' . str_pad($category->next_sku_number, 3, '0', STR_PAD_LEFT);

while (Product::where('sku', $sku)->exists()) {

    $category->increment('next_sku_number');

    $category->refresh();

    $sku = $prefix . '-' . str_pad($category->next_sku_number, 3, '0', STR_PAD_LEFT);
}

$category->increment('next_sku_number');
   
    $product = Product::create([

        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'sku' => $sku,
        'description' => $request->description,
        'price' => $request->price,
        'compare_price' => $request->compare_price,
        'cost_price' => $request->cost_price,
        'stock' => $request->stock ?? 0,

        'weight' => $request->weight,
        'length' => $request->length,
        'width' => $request->width,
        'height' => $request->height,

        'featured_image' => $featuredImage,

        'featured' => $request->featured,
        'status' => $request->status,

        'meta_title' => $request->meta_title,
        'meta_keywords' => $request->meta_keywords,
        'meta_description' => $request->meta_description,

        'product_type' => $request->product_type,

        'track_inventory' => $request->track_inventory,
        'low_stock_alert' => $request->low_stock_alert,
        'continue_selling' => $request->continue_selling,
        'stock_status' => $request->stock_status,

    ]);

    if ($request->has('attributes')) {

    foreach ($request->input('attributes') as $attributeId => $value) {

        if (empty($value)) {
            continue;
        }

        ProductAttributeData::create([

            'product_id' => $product->id,
            'attribute_id' => $attributeId,
            'attribute_value_id' => is_numeric($value) ? $value : null,
            'custom_value' => !is_numeric($value) ? $value : null,

        ]);

    }

}



    if ($request->hasFile('gallery')) {

        foreach ($request->file('gallery') as $index => $image) {

            ProductImage::create([

                'product_id' => $product->id,
                'image' => $image->store('products/gallery', 'public'),
                'sort_order' => $index,
                'is_primary' => ($index == 0),

            ]);

        }

    }

});

return redirect()
    ->route('products.index')
    ->with('success', 'Product Created Successfully.');

}
    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
{
    $categories = Category::orderBy('name')->get();

    $product->load([
        'images',
        'attributeData'
    ]);

    return view(
        'admin.products.edit',
        compact(
            'product',
            'categories'
        )
    );
}

    public function update(Request $request, Product $product)
{
    $validated = $request->validate([

        'category_id' => 'required|exists:categories,id',
        'name' => 'required|max:255',
        'sku' => 'required|max:255|unique:products,sku,' . $product->id,
        'price' => 'required|numeric',

        'length' => 'nullable|numeric',
        'width' => 'nullable|numeric',
        'height' => 'nullable|numeric',

        'product_type' => 'required|in:simple,variable',

        'compare_price' => 'nullable|numeric',
        'cost_price' => 'nullable|numeric',

        'stock' => 'nullable|integer',
        'weight' => 'nullable|numeric',

        'description' => 'nullable',

        'meta_title' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable',
        'meta_description' => 'nullable',

        'status' => 'required|boolean',
        'featured' => 'required|boolean',

        'featured_image' => 'nullable|image|max:4096',
        'product_type' => 'required|in:simple,variable',
        'track_inventory' => 'required|boolean',
        'low_stock_alert' => 'required|integer|min:0',
        'continue_selling' => 'required|boolean',
        'stock_status' => 'required|in:in_stock,out_of_stock,pre_order',

    ]);

    if($request->hasFile('featured_image')){

        if($product->featured_image &&
            \Storage::disk('public')->exists($product->featured_image)){

            \Storage::disk('public')->delete(
                $product->featured_image
            );

        }

        $validated['featured_image'] = $request
            ->file('featured_image')
            ->store('products','public');

    }

    
    DB::transaction(function () use ($request, $product, &$validated) {

    $product->update($validated);

    // Save Product Attributes
    $product->attributeData()->delete();

if ($request->has('attributes')) {

    foreach ($request->input('attributes', []) as $attributeId => $value) {

        if (empty($value)) {
            continue;
        }

        ProductAttributeData::create([
            'product_id' => $product->id,
            'attribute_id' => $attributeId,
            'attribute_value_id' => is_numeric($value) ? $value : null,
            'custom_value' => !is_numeric($value) ? $value : null,
        ]);
    }

}

    if ($request->hasFile('gallery')) {

    foreach ($request->file('gallery') as $index => $image) {

        ProductImage::create([

            'product_id' => $product->id,

            'image' => $image->store(
                'products/gallery',
                'public'
            ),

            'sort_order' => $index,

            'is_primary' => ($index == 0),

        ]);

    }

}

});

    return redirect()
        ->route('products.index')
        ->with(
            'success',
            'Product Updated Successfully.'
        );
}

    public function getCategoryAttributes(Request $request, $categoryId)
{
    $category = Category::with('attributes.values')->findOrFail($categoryId);

    $attributes = $category->attributes;

    $selected = [];

    if ($request->filled('product_id')) {

        $selected = ProductAttributeData::where('product_id', $request->product_id)
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->attribute_id => $item->attribute_value_id ?? $item->custom_value
                ];
            })
            ->toArray();

    }

    return view(
        'admin.products.attribute-fields',
        compact('attributes', 'selected')
    );
}

}