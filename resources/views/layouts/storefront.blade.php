<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ocean Ecom - Premium Luxury E-Commerce')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23FF6B00%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><circle cx=%228%22 cy=%2221%22 r=%221%22></circle><circle cx=%2219%22 cy=%2221%22 r=%221%22></circle><path d=%22M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12%22></path></svg>">
    <!-- Premium Fonts -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Sticky Header & Navigation -->
    <header class="glass">
        <div class="nav-container">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="logo">
                Ocean <span>Ecom</span>
            </a>

            <!-- Navigation Links & Mega Menu Trigger -->
            <div class="nav-links">
                <div class="mega-menu-wrapper">
                    <a href="{{ route('shop') }}" class="nav-link category-dropdown-trigger">
                        Categories
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </a>
                    <!-- Mega Menu -->
                    <div class="mega-menu glass">
                        <div class="mega-column">
                        <div class="mega-column">
                            <h4>Collections</h4>
                            <ul>
                                @foreach(\App\Models\Category::all() as $cat)
                                    <li><a href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        </div>
                        <div class="mega-column">
                            <h4>Pages Quick Link</h4>
                            <ul>
                                <li><a href="{{ route('offers') }}">Deals & Offers</a></li>
                                <li><a href="{{ route('blog') }}">Insights Blog</a></li>
                                <li><a href="{{ route('about') }}">Our Story</a></li>
                                <li><a href="{{ route('contact') }}">Contact Support</a></li>
                            </ul>
                        </div>
                        <div class="mega-promo-card">
                            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Couture Edition</h3>
                            <p style="font-size: 0.85rem; margin-bottom: 1rem; opacity: 0.8;">Explore our newly launched summer couture apparel collection.</p>
                            <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.8rem; width: fit-content;">Shop Now</a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('shop') }}" class="nav-link">Shop All</a>
                <a href="{{ route('offers') }}" class="nav-link">Offers</a>
                <a href="{{ route('blog') }}" class="nav-link">Blog</a>
            </div>

            <!-- Live Search Bar -->
            <div class="search-wrapper">
                <form action="{{ route('search') }}" method="GET">
                    <button type="submit" class="search-icon-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </button>
                    <input type="text" name="q" placeholder="Search premium products..." class="search-bar" autocomplete="off">
                </form>
                <!-- Live suggestions dropdown -->
                <div class="search-suggestions glass">
                    <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); margin-bottom: 0.5rem;">Suggested Products</div>
                    <a href="{{ route('product.details', 'sonicwave-anc-headphones') }}" class="suggestion-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 16-5.05-1.44a2 2 0 0 0-2.42 1.44l-.74 2.58a16 16 0 0 1-6.56-6.56l2.58-.74a2 2 0 0 0 1.44-2.42L5.28 3.02"/></svg>
                        <span>SonicWave ANC Headphones</span>
                    </a>
                    <a href="{{ route('product.details', 'chrono-legacy-automatic-watch') }}" class="suggestion-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                        <span>Chrono Legacy Automatic Watch</span>
                    </a>
                    <a href="{{ route('product.details', 'nomad-waterproof-backpack') }}" class="suggestion-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <span>Nomad Waterproof Backpack</span>
                    </a>
                </div>
            </div>

            <!-- Actions (Account, Wishlist, Cart, Theme Toggle) -->
            <div class="nav-actions">
                <button class="action-btn theme-toggle" title="Toggle Theme">
                    <!-- Loaded dynamically via js -->
                </button>
                <span id="nav-user-container">
                    @auth
                        <div class="user-dropdown-wrapper" style="position: relative; display: inline-block;">
                            <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap:0.5rem; text-decoration:none; color:var(--text-primary); font-weight:700; font-size:0.9rem;" title="Go to Dashboard">
                                <div style="width:28px; height:28px; border-radius:50%; background:var(--primary); color:white; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <span class="user-name-header" style="max-width:80px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ auth()->user()->name }}</span>
                                <span style="font-size: 0.55rem; color: var(--text-secondary); margin-left: 2px;">▼</span>
                            </a>
                            <div class="user-dropdown-menu glass" style="display: none; position: absolute; top: 100%; right: 0; width: 170px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); box-shadow: var(--shadow-md); z-index: 10000; overflow: hidden; padding: 0.5rem 0;">
                                <style>
                                    .user-dropdown-wrapper:hover .user-dropdown-menu {
                                        display: block !important;
                                    }
                                </style>
                                <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column;">
                                    <li><a href="{{ route('my-profile') }}" style="display: block; padding: 0.6rem 1rem; color: var(--text-primary); text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: var(--transition);" onmouseover="this.style.background='rgba(0,0,0,0.05)'" onmouseout="this.style.background='none'">My Profile</a></li>
                                    <li><a href="{{ route('my-orders') }}" style="display: block; padding: 0.6rem 1rem; color: var(--text-primary); text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: var(--transition);" onmouseover="this.style.background='rgba(0,0,0,0.05)'" onmouseout="this.style.background='none'">My Orders</a></li>
                                    <li><a href="{{ route('my-wishlist') }}" style="display: block; padding: 0.6rem 1rem; color: var(--text-primary); text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: var(--transition);" onmouseover="this.style.background='rgba(0,0,0,0.05)'" onmouseout="this.style.background='none'">My Wishlist</a></li>
                                    <li><a href="{{ route('saved-addresses') }}" style="display: block; padding: 0.6rem 1rem; color: var(--text-primary); text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: var(--transition);" onmouseover="this.style.background='rgba(0,0,0,0.05)'" onmouseout="this.style.background='none'">Saved Addresses</a></li>
                                    <li style="border-top: 1px solid var(--border-color); margin-top: 0.25rem; padding-top: 0.25rem;">
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();" style="display: block; padding: 0.6rem 1rem; color: #EF4444; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: var(--transition);" onmouseover="this.style.background='rgba(239,68,68,0.05)'" onmouseout="this.style.background='none'">Logout</a>
                                        <form id="header-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('auth') }}" class="action-btn" title="Sign In">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </a>
                    @endauth
                </span>
                <a href="{{ route('dashboard') }}?tab=wishlist" class="action-btn" title="My Wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    <span class="badge wishlist-badge">0</span>
                </a>
                <button class="action-btn cart-toggle-trigger" title="Shopping Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    <span class="badge cart-badge">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Floating Actions -->
    <button class="floating-cart cart-toggle-trigger">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
        <span class="badge cart-badge" style="top: -4px; right: -4px;">0</span>
    </button>
    <button class="scroll-to-top">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>

    <!-- Side Cart Drawer Overlay & Drawer -->
    <div class="cart-drawer-overlay"></div>
    <div class="cart-drawer">
        <div class="cart-drawer-header">
            <h3>Shopping Bag</h3>
            <button class="close-drawer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>
        <div class="cart-drawer-body cart-drawer-list">
            <!-- Populated via Javascript -->
        </div>
        <div class="cart-drawer-footer">
            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span id="drawer-subtotal">$0.00</span>
            </div>
            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 1rem;">Taxes and shipping calculated at checkout.</p>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('cart') }}" class="btn btn-outline" style="width: 100%;">View Cart</a>
                <a href="{{ route('checkout') }}" class="btn btn-primary" style="width: 100%;">Proceed To Checkout</a>
            </div>
        </div>
    </div>

    <!-- Premium Modern Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h2 style="font-weight: 800; font-size: 1.5rem; color: white; margin-bottom: 1.5rem;">Ocean <span>Ecom</span></h2>
                <p>Curators of luxury, premium lifestyle products. Delivering aesthetic distinction and performance to modern shoppers globally.</p>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <!-- Social icons mock -->
                    <a href="#" style="color: var(--primary); display: flex; align-items: center;" title="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="#" style="color: white; opacity: 0.8; display: flex; align-items: center; transition: var(--transition);" title="Twitter" onmouseover="this.style.opacity=1; this.style.color='var(--primary)'" onmouseout="this.style.opacity=0.8; this.style.color='white'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></svg>
                    </a>
                    <a href="#" style="color: white; opacity: 0.8; display: flex; align-items: center; transition: var(--transition);" title="Pinterest" onmouseover="this.style.opacity=1; this.style.color='var(--primary)'" onmouseout="this.style.opacity=0.8; this.style.color='white'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 22a10 10 0 0 1-1.91-8.39c.54-2.4 2.23-6.4 5.91-6.4 2.8 0 4 2.05 4 4.56 0 2.81-1.22 5.16-3 5.16-1 0-1.62-.79-1.39-1.74.27-1.12.78-2.32.78-3.13 0-.72-.39-1.32-1.22-1.32-1 0-1.74 1-1.74 2.37 0 .86.3 1.44.3 1.44l-1.2 5.07C7.8 21.57 8 22 8 22z"></path></svg>
                    </a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Shopping</h3>
                <ul>
                    <li><a href="{{ route('shop') }}">New Arrivals</a></li>
                    <li><a href="{{ route('shop') }}">Best Sellers</a></li>
                    <li><a href="{{ route('offers') }}">Special Deals</a></li>
                    <li><a href="{{ route('brand') }}">Our Brands</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Support</h3>
                <ul>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('faq') }}">FAQ & Help</a></li>
                    <li><a href="{{ route('track.order') }}">Track Order</a></li>
                    <li><a href="{{ route('legal', 'returns') }}">Returns & Refund</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Management</h3>
                <ul>
                    <li><a href="{{ route('admin') }}" style="color: var(--primary); font-weight: 700;">Admin Panel</a></li>
                    <li><a href="{{ route('legal', 'privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('legal', 'terms') }}">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="footer-column" style="grid-column: span 1;">
                <h3>Registered Office Address</h3>
                <p style="font-size: 0.85rem; line-height: 1.6; color: #9CA3AF;">
                    Office no - 103, Alpha One Complex,<br>
                    150 Feet Ring Rd, nr. Ambedakar Chowk,<br>
                    Ambedkar Nagar, Samrat Industrial Area,<br>
                    Rajkot, Gujarat 360004
                </p>
            </div>
        </div>

        <div style="max-width: 1400px; margin: 0 auto; margin-bottom: 2rem;">
            <h4 style="font-size: 1.1rem; font-weight: 700; color: white; margin-bottom: 1rem;">Instagram Gallery @OceanEcom</h4>
            <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem;">
                <div style="border-radius: var(--radius-sm); overflow: hidden; height: 100px; background: rgba(255,255,255,0.05);"><img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=150&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover; opacity: 0.8; transition: var(--transition);" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8"></div>
                <div style="border-radius: var(--radius-sm); overflow: hidden; height: 100px; background: rgba(255,255,255,0.05);"><img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=150&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover; opacity: 0.8; transition: var(--transition);" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8"></div>
                <div style="border-radius: var(--radius-sm); overflow: hidden; height: 100px; background: rgba(255,255,255,0.05);"><img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=150&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover; opacity: 0.8; transition: var(--transition);" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8"></div>
                <div style="border-radius: var(--radius-sm); overflow: hidden; height: 100px; background: rgba(255,255,255,0.05);"><img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=150&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover; opacity: 0.8; transition: var(--transition);" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8"></div>
                <div style="border-radius: var(--radius-sm); overflow: hidden; height: 100px; background: rgba(255,255,255,0.05);"><img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?w=150&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover; opacity: 0.8; transition: var(--transition);" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8"></div>
                <div style="border-radius: var(--radius-sm); overflow: hidden; height: 100px; background: rgba(255,255,255,0.05);"><img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=150&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover; opacity: 0.8; transition: var(--transition);" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8"></div>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; 2026 Ocean Ecom. All Rights Reserved.</div>
            <div style="display: flex; gap: 1.5rem;">
                <span>Visa / Mastercard / ApplePay / GPay</span>
            </div>
        </div>
    </footer>

    <!-- Core interactive Script -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                window.showToast("{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                window.showToast("{{ session('error') }}", 'error');
            @endif
            @if(session('info'))
                window.showToast("{{ session('info') }}", 'info');
            @endif
        });
    </script>
    @yield('scripts')
</body>
</html>
