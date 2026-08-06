<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to place an order.'], 401);
        }

        $request->validate([
            'total' => ['required', 'numeric'],
            'items' => ['required', 'array'],
        ]);

        $orderNumber = 'VLX-2026-' . rand(10000, 99999);

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'total' => $request->total,
            'items' => $request->items,
            'status' => 'Confirmed' // Default status
        ]);

        // Reduce product stock based on ordered items
        foreach ($request->items as $item) {
            if (isset($item['id'])) {
                $product = \App\Models\Product::find($item['id']);
                if ($product) {
                    // Decrement stock by quantity purchased
                    $product->decrement('stock', intval($item['qty'] ?? 1));
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'order_number' => $orderNumber
        ]);
    }

    public function getOrderStatus(Request $request)
    {
        $request->validate([
            'order_number' => ['required', 'string'],
        ]);

        if (!\Illuminate\Support\Facades\Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to track your order.'
            ], 401);
        }

        $order = Order::where('order_number', $request->order_number)->first();

        if ($order) {
            if ($order->user_id !== \Illuminate\Support\Facades\Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access. You can only track your own orders.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'status' => $order->status,
                'order_number' => $order->order_number,
                'total' => $order->total,
                'date' => $order->created_at->format('M d, Y')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Consignment not found in database.'
        ], 404);
    }

    public function returnOrder(Request $request, $id)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to return an order.'], 401);
        }

        $request->validate([
            'reason' => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string'],
        ]);

        $order = Order::where('id', $id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();

        if ($order->status !== 'Delivered') {
            return response()->json(['success' => false, 'message' => 'Only delivered orders can be returned.'], 400);
        }

        $order->status = 'Returned';
        $order->return_reason = $request->reason;
        $order->return_comment = $request->comment;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order returned successfully!'
        ]);
    }
}
