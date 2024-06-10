<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        $review = new Review();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->product_id = $product->id;
        if ($request->anonymous == 'on') {
            $review->user_id = null;
        } else {
            $review->user_id = auth()->id();
        }
        
        // $review->user_id = auth()->id();
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully');
    }
}
