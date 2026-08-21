<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $categories = \App\Models\Category::latest()->get();

    return view('admin.categories.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.categories.create');
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
    'name' => 'required|max:255',
    'sku_prefix' => 'required|max:10|unique:categories,sku_prefix',
    'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
]);

    $imageName = null;

    if ($request->hasFile('image')) {

        $imageName = time().'.'.$request->image->extension();

        $request->image->storeAs(
            'categories',
            $imageName,
            'public'
        );
    }

    \App\Models\Category::create([
    'name'            => $request->name,
    'slug'            => \Illuminate\Support\Str::slug($request->name),
    'sku_prefix'      => strtoupper($request->sku_prefix),
    'next_sku_number' => 1,
    'image'           => $imageName,
]);

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category Created Successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
{
    $category = \App\Models\Category::findOrFail($id);

    return view('admin.categories.edit', compact('category'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $category = \App\Models\Category::findOrFail($id);

$request->validate([
    'name' => 'required|max:255',
    'sku_prefix' => 'required|max:10|unique:categories,sku_prefix,' . $category->id,
]);

    $category->update([
    'name'       => $request->name,
    'slug'       => \Illuminate\Support\Str::slug($request->name),
    'sku_prefix' => strtoupper($request->sku_prefix),
]);

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category Updated Successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $category = \App\Models\Category::findOrFail($id);

    $category->delete();

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category Deleted Successfully.');
}
}
