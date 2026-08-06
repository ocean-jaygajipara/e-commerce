<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to submit a review.'], 401);
        }

        $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $product = Product::findOrFail($id);

        // Verify if user has a delivered order for this product
        $hasDeliveredOrder = false;
        $deliveredOrders = Order::where('user_id', Auth::id())
            ->where('status', 'Delivered')
            ->get();
        foreach ($deliveredOrders as $order) {
            foreach ($order->items as $item) {
                if (isset($item['id']) && $item['id'] == $product->id) {
                    $hasDeliveredOrder = true;
                    break 2;
                }
            }
        }

        if (!$hasDeliveredOrder) {
            return response()->json(['success' => false, 'message' => 'You can only review this product after it is delivered to you.'], 403);
        }

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())->where('product_id', $product->id)->first();
        if ($existingReview) {
            return response()->json(['success' => false, 'message' => 'You have already reviewed this product.'], 400);
        }

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Recalculate average rating and reviews count
        $allReviews = $product->reviews;
        $count = $allReviews->count();
        $avg = $allReviews->avg('rating');

        $product->rating = round($avg, 1);
        $product->reviews_count = $count;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!'
        ]);
    }
}
