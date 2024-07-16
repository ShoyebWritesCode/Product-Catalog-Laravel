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

    public function sizesIndex()
    {
        $sizes = Size::all();
        return view('admin.sizes', compact('sizes'));
    }
}
