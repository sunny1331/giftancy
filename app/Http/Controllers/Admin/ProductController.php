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
    'name'            => 'required|max:255',
    'category_id'     => 'required|exists:categories,id',
    'sku'             => 'required|unique:products,sku',
    'price'           => 'required|numeric',

    'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

    'gallery.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
]);

$featuredImage = null;

if ($request->hasFile('featured_image')) {

    $featuredImage = $request
        ->file('featured_image')
        ->store('products', 'public');

}

    $product = Product::create([
        'category_id' => $request->category_id,
        'name'        => $request->name,
        'slug'        => Str::slug($request->name),
        'sku'         => $request->sku,
        'featured_image' => $featuredImage,
        'price'       => $request->price,
        'dimensions' => $request->dimensions,
        'stock'       => 0,
        'status' => $request->status,
    ]);

if ($request->has('attributes')) {

    foreach ($request->attributes as $attributeId => $value) {

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

            'is_featured' => false,

        ]);

    }

}

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
        'sku' => 'required|max:255',
        'price' => 'required|numeric',

        'compare_price' => 'nullable|numeric',
        'cost_price' => 'nullable|numeric',

        'stock' => 'nullable|integer',
        'weight' => 'nullable|numeric',

        'dimensions' => 'nullable|string',

        'description' => 'nullable',

        'meta_title' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable',
        'meta_description' => 'nullable',

        'status' => 'required|boolean',
        'featured' => 'required|boolean',

        'featured_image' => 'nullable|image|max:4096',

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

    $product->update($validated);


    // Save Product Attributes
$product->attributeData()->delete();

foreach ($request->input('attributes', []) as $attributeId => $value) {

    if (empty($value)) {
        continue;
    }

    ProductAttributeData::create([
        'product_id' => $product->id,
        'attribute_id' => $attributeId,
        'attribute_value_id' => $value,
        'value' => null,
    ]);
}

if ($request->has('attributes')) {

    foreach ($request->attributes as $attributeId => $value) {

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

    if($request->hasFile('gallery')){

    foreach($request->file('gallery') as $image){

        ProductImage::create([

            'product_id' => $product->id,

            'image' => $image->store(
                'products/gallery',
                'public'
            ),

        ]);

    }

}

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

        $selected = ProductAttributeData::where(
            'product_id',
            $request->product_id
        )
        ->pluck('attribute_value_id', 'attribute_id')
        ->toArray();

    }

    return view(
        'admin.products.attribute-fields',
        compact('attributes', 'selected')
    );
}

    public function destroy(string $id)
    {
        //
    }
}