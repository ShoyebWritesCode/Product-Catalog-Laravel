<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;
use App\Models\Inventory;

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

    public function getInventoryQuantity(Request $request)
    {
        $sizeId = $request->query('size_id');
        $colorId = $request->query('color_id');
        $productId = $request->query('product_id');

        $inventory = Inventory::where('size_id', $sizeId)
            ->where('color_id', $colorId)
            ->where('product_id', $productId)
            ->first();

        if ($inventory) {
            return response()->json(['success' => true, 'quantity' => $inventory->quantity]);
        } else {
            return response()->json(['success' => false, 'quantity' => 0]);
        }
    }
}
