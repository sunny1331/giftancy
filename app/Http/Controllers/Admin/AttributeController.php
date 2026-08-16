<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->get();

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Attribute::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'field_type' => $request->field_type,
            'group_name' => $request->group_name,
            'is_filterable' => $request->has('is_filterable'),
            'is_active' => true,
        ]);

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Attribute Created Successfully.');
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
{
    $request->validate([
        'name' => 'required|max:255',
    ]);

    $attribute->update([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'field_type' => $request->field_type,
        'group_name' => $request->group_name,
        'is_filterable' => $request->has('is_filterable'),
    ]);

    return redirect()
        ->route('attributes.index')
        ->with('success', 'Attribute Updated Successfully.');
}

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Attribute Deleted Successfully.');
    }
}