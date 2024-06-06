<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Catagory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CatagoryController extends Controller
{
    public function index()
    {
        $categories = Catagory::whereNull('parent_id')->get();
        $subcategories = Catagory::whereNotNull('parent_id')->get();
        return view('admin.catagory.home',compact('categories','subcategories'));
    }

    public function create()
    {
        $categories = Catagory::whereNull('parent_id')->get();
        return view('admin.catagory.create',compact('categories'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'subcategory_of' => 'nullable|string|exists:catagories,name',
        ]);
        Log::info($request->all());

        $catagory = new Catagory();
        $catagory->name = $request->name;
        if ($request->subcategory_of) {
            $parentCategory = Catagory::where('id', $request->subcategory_of)->first();
            $catagory->parent_id = $parentCategory->id;
        }
        $catagory->save();
        session()->flash('success', 'Catagory created successfully');
        return redirect()->route('admin.catagory.home')->with('success', 'Catagory created successfully');
    } 


}