<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                $route = $request->route() ? $request->route()->getName() : '';
                if (!session('admin_logged_in') && !in_array($route, ['admin.login', 'admin.login.submit'])) {
                    return redirect()->route('admin.login');
                }
                return $next($request);
            }
        ];
    }

    public function index()
    {
        // Calculate statistics
        $totalOrdersCount = Order::count();
        $totalRevenue = Order::sum('total');
        $totalUsersCount = User::count();

        // Fetch orders with user details
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();

        // Fetch registered users
        $users = User::orderBy('created_at', 'desc')->get();

        // Fetch Categories and Products
        $categories = Category::orderBy('name', 'asc')->get();
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();

        // Determine active tab based on route names
        $activeTab = 'overview';
        if (request()->routeIs('admin.orders')) {
            $activeTab = 'orders';
        } elseif (request()->routeIs('admin.categories')) {
            $activeTab = 'categories';
        } elseif (request()->routeIs('admin.products')) {
            $activeTab = 'products';
        } elseif (request()->routeIs('admin.customers')) {
            $activeTab = 'users';
        }

        return view('admin', compact(
            'totalOrdersCount',
            'totalRevenue',
            'totalUsersCount',
            'orders',
            'users',
            'categories',
            'products',
            'activeTab'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:Confirmed,Packed,Shipped,Delivered,Returned'],
        ]);

        $order = Order::findOrFail($id);

        if ($order->status === 'Delivered') {
            return response()->json([
                'success' => false,
                'message' => "This order has already been Delivered. Status cannot be modified anymore."
            ], 422);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => "Order #{$order->order_number} status updated to {$request->status} successfully!"
        ]);
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['required', 'string', 'max:10'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'id' => ['nullable', 'integer', 'exists:products,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'img' => ['required', 'url'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        if ($request->id) {
            $product = Product::findOrFail($request->id);
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'brand' => $request->brand,
                'price' => $request->price,
                'description' => $request->description,
                'img' => $request->img,
                'stock' => $request->stock,
            ]);
            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'description' => $request->description,
            'img' => $request->img,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($request->username === 'admin' && $request->password === 'admin') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin')->with('success', 'Welcome back, Admin!');
        }

        return redirect()->back()->withErrors(['login_error' => 'Invalid admin credentials.'])->withInput();
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}
