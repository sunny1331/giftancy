<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    public function index()
    {
        $values = AttributeValue::with('attribute')
            ->latest()
            ->get();

        return view('admin.attribute-values.index', compact('values'));
    }

    public function create()
    {
        $attributes = Attribute::orderBy('name')->get();

        return view('admin.attribute-values.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|max:255',
        ]);

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'slug' => Str::slug($request->value),
        ]);

        return redirect()
            ->route('attribute-values.index')
            ->with('success', 'Attribute Value Created Successfully.');
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::orderBy('name')->get();

        return view('admin.attribute-values.edit', compact('attributeValue', 'attributes'));
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|max:255',
        ]);

        $attributeValue->update([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'slug' => Str::slug($request->value),
        ]);

        return redirect()
            ->route('attribute-values.index')
            ->with('success', 'Attribute Value Updated Successfully.');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return redirect()
            ->route('attribute-values.index')
            ->with('success', 'Attribute Value Deleted Successfully.');
    }
}