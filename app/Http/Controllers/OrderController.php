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
            'promo_code' => ['nullable', 'string', 'max:50'],
            'fullname' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'pincode' => ['nullable', 'string', 'max:10'],
        ]);

        $user = Auth::user();
        if ($user) {
            $user->update([
                'fullname' => $request->fullname,
                'address' => $request->address,
                'city' => $request->city,
                'pincode' => $request->pincode,
            ]);
        }

        // First check: Verify stock for all items before placing the order
        foreach ($request->items as $item) {
            if (isset($item['id'])) {
                $product = \App\Models\Product::find($item['id']);
                if (!$product) {
                    return response()->json(['success' => false, 'message' => 'Product not found.'], 400);
                }

                $qty = intval($item['qty'] ?? 1);
                $itemName = $item['name'] ?? '';
                $colorName = null;
                if (preg_match('/\(([^)]+)\)/', $itemName, $matches)) {
                    $colorName = trim($matches[1]);
                }

                if ($product->colors && is_array($product->colors) && count($product->colors) > 0 && $colorName) {
                    $foundVariant = false;
                    foreach ($product->colors as $variant) {
                        if (is_array($variant) && isset($variant['name']) && strtolower($variant['name']) === strtolower($colorName)) {
                            $foundVariant = true;
                            if (intval($variant['stock'] ?? 0) < $qty) {
                                return response()->json([
                                    'success' => false,
                                    'message' => "Only " . ($variant['stock'] ?? 0) . " units left for color variant '{$colorName}' of product '{$product->name}'."
                                ], 400);
                            }
                            break;
                        }
                    }
                } else {
                    if ($product->stock < $qty) {
                        return response()->json([
                            'success' => false,
                            'message' => "Only {$product->stock} units left for product '{$product->name}'."
                        ], 400);
                    }
                }
            }
        }

        $orderNumber = 'VLX-2026-' . rand(10000, 99999);

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'total' => $request->total,
            'items' => $request->items,
            'promo_code' => $request->promo_code,
            'status' => 'Confirmed'
        ]);

        // Reduce product stock based on ordered items
        foreach ($request->items as $item) {
            if (isset($item['id'])) {
                $product = \App\Models\Product::find($item['id']);
                if ($product) {
                    $qty = intval($item['qty'] ?? 1);
                    $itemName = $item['name'] ?? '';
                    $colorName = null;
                    if (preg_match('/\(([^)]+)\)/', $itemName, $matches)) {
                        $colorName = trim($matches[1]);
                    }

                    if ($product->colors && is_array($product->colors) && count($product->colors) > 0 && $colorName) {
                        $updatedColors = [];
                        foreach ($product->colors as $variant) {
                            if (is_array($variant) && isset($variant['name']) && strtolower($variant['name']) === strtolower($colorName)) {
                                $variant['stock'] = max(0, intval($variant['stock'] ?? 0) - $qty);
                            }
                            $updatedColors[] = $variant;
                        }
                        $product->colors = $updatedColors;
                    }
                    
                    $product->stock = max(0, $product->stock - $qty);
                    $product->save();
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
                'id' => $order->id,
                'status' => $order->status,
                'order_number' => $order->order_number,
                'total' => $order->total,
                'items' => $order->items,
                'date' => $order->created_at->format('M d, Y'),
                'shipping_address' => [
                    'fullname' => $order->user->fullname ?? $order->user->name,
                    'address' => $order->user->address ?? '',
                    'city' => $order->user->city ?? '',
                    'pincode' => $order->user->pincode ?? ''
                ]
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
