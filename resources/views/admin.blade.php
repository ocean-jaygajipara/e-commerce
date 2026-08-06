    <!DOCTYPE html>
    <html lang="en" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Store Administration - VELOX</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            :root {
                --bg-primary: #f8f9fa;
                --bg-secondary: #ffffff;
                --border-color: rgba(0, 0, 0, 0.08);
                --text-primary: #0A0A0B;
                --text-secondary: #6B7280;
                --white: #FFFFFF;
                --primary: #FF6B00;
                --radius-sm: 8px;
                --radius-md: 16px;
                --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            [data-theme="dark"] {
                --bg-primary: #0f0f12;
                --bg-secondary: #16161a;
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #F4F4F6;
            --text-secondary: #9CA3AF;
            --white: #0A0A0B;
        }

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background: var(--bg-primary);
            color: var(--text-primary);
            display: flex;
            height: 100vh;
            overflow: hidden;
            transition: var(--transition);
        }

        /* Select2 Theme Tweaks */
        .select2-container,
        .select2,
        .select2-container--default {
            z-index: 999999 !important;
            width: 100% !important;
            display: block;
        }
        .select2-container--default .select2-selection--single {
            background-color: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: var(--radius-sm) !important;
            height: auto !important;
            padding: 0.4rem 0.8rem !important;
            color: var(--text-primary) !important;
            display: flex;
            align-items: center;
            font-family: inherit;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-primary) !important;
            font-weight: 600;
            padding: 0 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            top: 0 !important;
        }
        .select2-dropdown {
            background-color: var(--bg-secondary) !important;
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: var(--radius-sm) !important;
            color: var(--text-primary) !important;
            z-index: 9999999 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15) !important;
        }
        .select2-container--default .select2-results__option {
            background-color: var(--bg-secondary) !important;
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
            padding: 0.6rem 1rem !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: var(--bg-primary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            outline: none;
            border-radius: var(--radius-sm) !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary) !important;
            background: var(--primary) !important;
            color: var(--white) !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: rgba(255, 107, 0, 0.15) !important;
            color: var(--text-primary) !important;
        }

        /* Admin Sidebar Layout */
        .admin-sidebar {
            width: 240px;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            box-sizing: border-box;
            height: 100%;
        }

        .admin-logo {
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: 3px;
            color: var(--text-primary);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-logo span {
            color: var(--primary);
        }

        .admin-nav-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex-grow: 1;
        }

        /* Consistent Sidebar Buttons */
        .admin-nav-btn {
            background: none;
            border: 1px solid transparent;
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.95rem;
            text-align: left;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-nav-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 107, 0, 0.05);
        }

        .admin-nav-btn.active {
            color: var(--white) !important;
            background: var(--primary) !important;
            box-shadow: var(--shadow-sm);
        }

        .admin-sidebar-footer {
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        /* Main Workspace */
        .admin-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        /* Top Bar */
        .admin-topbar {
            height: 80px;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-sizing: border-box;
        }

        .admin-workspace {
            padding: 2rem;
            overflow-y: auto;
            flex-grow: 1;
            box-sizing: border-box;
            background: var(--bg-primary);
        }

        /* Custom scrollbar */
        .admin-workspace::-webkit-scrollbar {
            width: 8px;
        }
        .admin-workspace::-webkit-scrollbar-track {
            background: transparent;
        }
        .admin-workspace::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .admin-panel {
            display: none;
        }

        .admin-panel.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card p {
            margin: 0.5rem 0 0;
            font-size: 2.25rem;
            font-weight: 850;
            color: var(--text-primary);
        }

        .stat-icon {
            position: absolute;
            right: 1.5rem;
            bottom: 1rem;
            font-size: 3rem;
            opacity: 0.12;
        }

        /* Dashboard Tables */
        .admin-table-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        .admin-table th {
            padding: 1rem 0.75rem;
            border-bottom: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 700;
        }

        .admin-table td {
            padding: 1.25rem 0.75rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        /* Dark Theme overrides for Admin Panel */
        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .admin-table-card {
            background: rgba(22, 22, 26, 0.6);
            backdrop-filter: blur(15px);
        }

        /* Responsive Dashboard CSS Queries */
        @media (max-width: 1024px) {
            body {
                flex-direction: column !important;
                height: auto !important;
                overflow: auto !important;
            }
            .admin-sidebar {
                width: 100% !important;
                height: auto !important;
                border-right: none !important;
                border-bottom: 1px solid var(--border-color) !important;
                padding: 1.5rem !important;
            }
            .admin-logo {
                margin-bottom: 1.5rem !important;
                justify-content: center !important;
            }
            .admin-nav-list {
                flex-direction: row !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 0.5rem !important;
                margin-bottom: 1rem !important;
            }
            .admin-nav-btn {
                padding: 0.75rem 1rem !important;
                font-size: 0.85rem !important;
            }
            .admin-sidebar-footer {
                margin-top: 1rem !important;
                border-top: none !important;
                padding-top: 0 !important;
            }
            .admin-main {
                height: auto !important;
                overflow: visible !important;
            }
            .admin-topbar {
                padding: 0 1.5rem !important;
                height: 70px !important;
            }
            .admin-workspace {
                padding: 1.5rem !important;
            }
            .stats-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
                margin-bottom: 2rem !important;
            }
            form {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            form div {
                grid-column: span 1 !important;
            }
            .admin-table-card {
                padding: 1.25rem !important;
                overflow-x: auto !important;
            }
            .admin-table {
                min-width: 600px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Left Sidebar Menu -->
    <aside class="admin-sidebar">
        <div class="admin-logo" style="font-weight: 800; letter-spacing: 2px;">
            VELO<span style="color: var(--primary);">X</span><span style="font-size: 0.85rem; font-weight: 700; color: var(--text-secondary); background: var(--border-color); padding: 0.25rem 0.6rem; border-radius: 4px; margin-left: 0.5rem; letter-spacing: 1px;">ADMIN</span>
        </div>

        <nav class="admin-nav-list">
            <button class="admin-nav-btn {{ $activeTab == 'overview' ? 'active' : '' }}" id="btn-overview" onclick="location.href='{{ route('admin') }}'">
                <span>📊</span> Overview Dashboard
            </button>
            <button class="admin-nav-btn {{ $activeTab == 'orders' ? 'active' : '' }}" id="btn-orders" onclick="location.href='{{ route('admin.orders') }}'">
                <span>📦</span> Placed Orders ({{ count($orders) }})
            </button>
            <button class="admin-nav-btn {{ $activeTab == 'categories' ? 'active' : '' }}" id="btn-categories" onclick="location.href='{{ route('admin.categories') }}'">
                <span>📁</span> Categories ({{ count($categories) }})
            </button>
            <button class="admin-nav-btn {{ $activeTab == 'products' ? 'active' : '' }}" id="btn-products" onclick="location.href='{{ route('admin.products') }}'">
                <span>💎</span> Products ({{ count($products) }})
            </button>
            <button class="admin-nav-btn {{ $activeTab == 'users' ? 'active' : '' }}" id="btn-users" onclick="location.href='{{ route('admin.customers') }}'">
                <span>👥</span> Customers ({{ count($users) }})
            </button>
        </nav>

        <div class="admin-sidebar-footer" style="display: flex; flex-direction: column; gap: 0.5rem;">
            <a href="{{ route('home') }}" class="btn btn-outline" style="text-align: center; text-decoration: none; font-size: 0.85rem; padding: 0.6rem;">
                ← Storefront
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0; width: 100%;">
                @csrf
                <button type="submit" class="btn btn-outline" style="width: 100%; text-align: center; font-size: 0.85rem; padding: 0.6rem; color: #EF4444; border-color: rgba(239, 68, 68, 0.2); cursor: pointer; background: none;">
                    Logout Admin
                </button>
            </form>
        </div>
    </aside>

    <!-- Right Workspace Area -->
    <div class="admin-main">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <div>
                <span style="font-size: 0.85rem; color: var(--text-secondary); font-weight: 500;">Server Status: <span style="color:#10B981; font-weight:700;">● Online</span></span>
            </div>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <!-- Theme Toggle Button -->
                <button class="action-btn theme-toggle" style="background:none; border:none; color:var(--text-primary); cursor:pointer; font-size:1.25rem;">
                    <!-- Managed via JS -->
                </button>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">AD</div>
                    <div>
                        <div style="font-size: 0.9rem; font-weight: 700;">Admin User</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">Store Manager</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Dashboard View Panels -->
        <div class="admin-workspace">
            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.15); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 2rem; font-weight: 600;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- 1. Overview Panel -->
            <div id="panel-overview" class="admin-panel active">
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Earnings</h3>
                        <p>₹{{ number_format($totalRevenue, 2) }}</p>
                        <div class="stat-icon">💸</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Sales</h3>
                        <p>{{ $totalOrdersCount }}</p>
                        <div class="stat-icon">📦</div>
                    </div>
                    <div class="stat-card">
                        <h3>Store Customers</h3>
                        <p>{{ $totalUsersCount }}</p>
                        <div class="stat-icon">👥</div>
                    </div>
                </div>

                <div class="admin-table-card">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin: 0 0 1.5rem;">System Overview</h3>
                    <p style="color: var(--text-secondary); line-height: 1.6; margin-bottom: 0;">Welcome to the store administration panel. Use the sidebar options to manage store components, add collections, and update order statuses dynamically.</p>
                </div>
            </div>

            <!-- 2. Orders Panel -->
            <div id="panel-orders" class="admin-panel">
                <div class="admin-table-card">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">Placed Orders</h3>
                    
                    @if($orders->isEmpty())
                        <div style="text-align: center; padding: 3rem 0; color: var(--text-secondary);">
                            No orders found in database. Place some orders on the store checkouts.
                        </div>
                    @else
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Customer</th>
                                    <th>Items Ordered</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Shipment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $item)
                                    <tr>
                                        <td style="font-weight: 700; color: var(--primary);">#{{ $item->order_number }}</td>
                                        <td>
                                            <div style="font-weight: 600;">{{ $item->user->name }}</div>
                                            <div style="font-size: 0.8rem; color: var(--text-secondary);">{{ $item->user->email }}</div>
                                        </td>
                                        <td>
                                            @foreach($item->items as $prod)
                                                <div style="font-size: 0.85rem;">{{ $prod['name'] }} (x{{ $prod['qty'] }})</div>
                                            @endforeach
                                        </td>
                                        <td style="font-weight: 700;">₹{{ number_format($item->total, 2) }}</td>
                                        <td style="color: var(--text-secondary);">{{ $item->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <select class="select2-status" onchange="updateOrderStatus({{ $item->id }}, this.value)" style="width: 150px;">
                                                <option value="Confirmed" {{ $item->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="Packed" {{ $item->status == 'Packed' ? 'selected' : '' }}>Packed</option>
                                                <option value="Shipped" {{ $item->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="Delivered" {{ $item->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- 3. Categories Panel -->
            <div id="panel-categories" class="admin-panel">
                <!-- Add Category Card -->
                <div class="admin-table-card" style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">Create New Category</h3>
                    <form action="{{ route('admin.category.add') }}" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        @csrf
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Category Name</label>
                            <input type="text" name="name" required placeholder="e.g. Smart Tech Accessories" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Icon Emoji</label>
                            <input type="text" name="icon" required placeholder="e.g. 🎧" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; box-sizing:border-box;">
                        </div>
                        <div style="grid-column: span 2;">
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Description</label>
                            <textarea name="description" placeholder="Specify short collection description..." style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; height: 80px; box-sizing:border-box;"></textarea>
                        </div>
                        <div style="grid-column: span 2;">
                            <button type="submit" class="btn btn-primary" style="padding:0.75rem 1.5rem;">Add Category</button>
                        </div>
                    </form>
                </div>

                <!-- Categories List -->
                <div class="admin-table-card">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">Category Directory</h3>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                                <tr>
                                    <td style="font-size: 1.5rem;">{{ $cat->icon }}</td>
                                    <td style="font-weight: 600;">{{ $cat->name }}</td>
                                    <td style="color: var(--text-secondary);">{{ $cat->slug }}</td>
                                    <td style="color: var(--text-secondary);">{{ $cat->description }}</td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.category.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Deleting category will also delete its products. Proceed?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #EF4444; cursor: pointer; font-weight: 600;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. Products Panel -->
            <div id="panel-products" class="admin-panel">
                <!-- Add Product Card -->
                <div class="admin-table-card" style="margin-bottom: 2rem;">
                    <h3 id="product-form-title" style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">Create New Product</h3>
                    <form id="product-form" action="{{ route('admin.product.add') }}" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        @csrf
                        <input type="hidden" id="edit-product-id" name="id" value="">
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Select Category</label>
                             <select name="category_id" required class="select2-category" style="width: 100%;">
                                <option value="" disabled selected>Select category...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Product Name</label>
                            <input type="text" name="name" required placeholder="e.g. AeroBuds Case Cover" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Brand Name</label>
                            <input type="text" name="brand" required placeholder="e.g. VELOX LUXURY" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Price (in Rupees ₹)</label>
                            <input type="number" step="0.01" name="price" required placeholder="e.g. 199.00" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Image URL</label>
                            <input type="url" name="img" required placeholder="e.g. https://images.unsplash.com/..." style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Stock Quantity</label>
                            <input type="number" name="stock" required placeholder="e.g. 20" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; box-sizing:border-box;">
                        </div>
                        <div style="grid-column: span 2;">
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Product Description</label>
                            <textarea name="description" required placeholder="Detailed specifications of the luxury item..." style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--bg-primary); color:var(--text-primary); outline:none; height: 100px; box-sizing:border-box;"></textarea>
                        </div>
                        <div style="grid-column: span 2; display: flex; gap: 1rem;">
                            <button type="submit" id="product-submit-btn" class="btn btn-primary" style="padding:0.75rem 1.5rem;">Add Product</button>
                            <button type="button" id="product-cancel-btn" class="btn btn-outline" style="padding:0.75rem 1.5rem; display:none;" onclick="cancelProductEdit()">Cancel Edit</button>
                        </div>
                    </form>
                </div>

                <!-- Products List -->
                <div class="admin-table-card">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">Product Catalog</h3>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Preview</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $prod)
                                <tr>
                                    <td>
                                        <img src="{{ $prod->img }}" style="width: 45px; height: 45px; border-radius: var(--radius-sm); object-fit: cover;">
                                    </td>
                                    <td style="font-weight: 600;">{{ $prod->name }}</td>
                                    <td>{{ $prod->category->name }}</td>
                                    <td style="color: var(--text-secondary);">{{ $prod->brand }}</td>
                                    <td style="font-weight: 700;">₹{{ number_format($prod->price, 2) }}</td>
                                    <td>{{ $prod->stock }} units</td>
                                    <td style="text-align: right;">
                                        <a href="javascript:void(0)" onclick="editProduct({{ json_encode($prod) }})" style="color: var(--primary); font-weight: 700; margin-right: 1.5rem; text-decoration: none; font-size: 0.9rem;">Edit</a>
                                        <form action="{{ route('admin.product.delete', $prod->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Delete this product permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #EF4444; cursor: pointer; font-weight: 600;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 5. Customers Panel -->
            <div id="panel-users" class="admin-panel">
                <div class="admin-table-card">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">Registered Customers</h3>
                    
                    @if($users->isEmpty())
                        <div style="text-align: center; padding: 3rem 0; color: var(--text-secondary);">
                            No registered customers in database.
                        </div>
                    @else
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Full Name</th>
                                    <th>Email Address</th>
                                    <th>Registered On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td style="font-weight: 700; color: var(--primary);">USR-{{ sprintf('%04d', $user->id) }}</td>
                                        <td style="font-weight: 600;">{{ $user->name }}</td>
                                        <td style="color: var(--text-secondary);">{{ $user->email }}</td>
                                        <td style="color: var(--text-secondary);">{{ $user->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-status').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
            $('.select2-category').select2({
                width: '100%'
            });
        });

        function switchTab(panelId) {
            // Hide all panels
            document.querySelectorAll('.admin-panel').forEach(panel => {
                panel.classList.remove('active');
            });
            
            // Remove active class from buttons
            document.querySelectorAll('.admin-nav-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected panel
            const activePanel = document.getElementById('panel-' + panelId);
            if (activePanel) {
                activePanel.classList.add('active');
            }

            // Add active class to corresponding button
            const activeBtn = document.getElementById('btn-' + panelId);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }

            // Save active tab in local session storage to persist on page reload
            localStorage.setItem('active_admin_workspace_tab', panelId);
        }

        // Auto-restore tab on load
        const savedTab = '{{ $activeTab ?? 'overview' }}';
        switchTab(savedTab);

        async function updateOrderStatus(orderId, newStatus) {
            const formData = new FormData();
            formData.append('status', newStatus);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch(`/admin/order/${orderId}/status`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                } else {
                    alert(data.message || 'Failed to update order status.');
                }
            } catch (error) {
                alert('An error occurred while updating order status.');
            }
        }

        window.editProduct = function(product) {
            document.getElementById('edit-product-id').value = product.id;
            document.getElementById('product-form-title').innerText = 'Edit Product: ' + product.name;
            
            // Populate select box (Select2)
            $('.select2-category').val(product.category_id).trigger('change');
            
            // Populate standard inputs
            document.querySelector('#product-form input[name="name"]').value = product.name;
            document.querySelector('#product-form input[name="brand"]').value = product.brand;
            document.querySelector('#product-form input[name="price"]').value = product.price;
            document.querySelector('#product-form input[name="img"]').value = product.img;
            document.querySelector('#product-form input[name="stock"]').value = product.stock;
            document.querySelector('#product-form textarea[name="description"]').value = product.description;
            
            // Change buttons
            document.getElementById('product-submit-btn').innerText = 'Save Changes';
            document.getElementById('product-cancel-btn').style.display = 'inline-block';
            
            // Scroll to form
            document.getElementById('product-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        window.cancelProductEdit = function() {
            document.getElementById('edit-product-id').value = '';
            document.getElementById('product-form-title').innerText = 'Create New Product';
            document.getElementById('product-form').reset();
            
            // Reset Select2
            $('.select2-category').val('').trigger('change');
            
            // Change buttons back
            document.getElementById('product-submit-btn').innerText = 'Add Product';
            document.getElementById('product-cancel-btn').style.display = 'none';
        }

        // Dark/Light Theme Control
        document.addEventListener('DOMContentLoaded', () => {
            const themeBtn = document.querySelector('.theme-toggle');
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(themeBtn, savedTheme);

            if (themeBtn) {
                themeBtn.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    updateThemeIcon(themeBtn, newTheme);
                });
            }

            function updateThemeIcon(btn, theme) {
                if (!btn) return;
                if (theme === 'dark') {
                    btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>`;
                } else {
                    btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>`;
                }
            }
        });
    </script>
</body>
</html>
