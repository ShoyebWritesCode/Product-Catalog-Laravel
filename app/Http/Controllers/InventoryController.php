<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;

class InventoryController extends Controller
{
    public function colorsIndex()
    {
        $colors = Color::all();
        return view('admin.colors', compact('colors'));
    }

    public function colorCreate(Request $request)
    {
        Color::create($request->all());
        return redirect()->back()->with('success', 'Color added successfully');
    }

    public function sizesIndex()
    {
        $sizes = Size::all();
        return view('admin.sizes', compact('sizes'));
    }

    public function sizeCreate(Request $request)
    {
        Size::create($request->all());
        return redirect()->back()->with('success', 'Size added successfully');
    }
}
