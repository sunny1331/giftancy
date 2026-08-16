<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryAttributeController extends Controller
{
    public function index(Category $category)
    {
        $attributes = Attribute::orderBy('name')->get();

        $selected = $category->attributes()
            ->pluck('attributes.id')
            ->toArray();

        return view(
            'admin.categories.attributes',
            compact('category', 'attributes', 'selected')
        );
    }

    public function store(Request $request, Category $category)
{
    $category->attributes()->sync(
        $request->input('attributes', [])
    );

    return redirect()
        ->back()
        ->with('success', 'Attributes Assigned Successfully.');
}

}