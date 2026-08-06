@extends('layouts.storefront')

@section('title', 'User Dashboard - VELOX')

@section('content')
<div style="display: flex; gap: 2.5rem; margin-top: 2rem; min-height: 600px;">
    <!-- Left Sidebar Navigation -->
    <aside style="width: 280px; flex-shrink: 0;">
        <div class="glass" style="border-radius: var(--radius-md); padding: 1.5rem; border: 1px solid var(--border-color);">
            <!-- Profile Overview Header -->
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <h4 style="font-size: 1rem; font-weight: 700;">{{ auth()->user()->name }}</h4>
                    <span style="font-size: 0.8rem; color: var(--text-secondary);">VIP Member</span>
                </div>
            </div>

            <!-- Tab Buttons -->
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <button class="dash-tab-btn active" onclick="switchDashTab('profile', this)">My Profile</button>
                <button class="dash-tab-btn" onclick="switchDashTab('orders', this)">My Orders & Tracking</button>
                <button class="dash-tab-btn" onclick="switchDashTab('wishlist', this); loadDashboardWishlist();">My Wishlist</button>
                <button class="dash-tab-btn" onclick="switchDashTab('addresses', this)">Saved Addresses</button>
                <button class="dash-tab-btn" onclick="switchDashTab('notifications', this)">Notifications</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="dash-tab-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #EF4444; text-align: left;">Logout</button>
            </div>
        </div>
    </aside>

    <!-- Right Dashboard Panels -->
    <div style="flex-grow: 1;">
        <!-- Panel 1: Profile & Edit Profile & Change Password -->
        <div id="panel-profile" class="dash-panel">
            <div class="glass" style="border-radius: var(--radius-md); padding: 2.5rem; border: 1px solid var(--border-color); margin-bottom: 2rem;">
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Edit Profile</h3>
                <form onsubmit="event.preventDefault(); alert('Profile updated!');" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Full Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Email Address</label>
                        <input type="email" value="{{ auth()->user()->email }}" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 2;">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <div class="glass" style="border-radius: var(--radius-md); padding: 2.5rem; border: 1px solid var(--border-color);">
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Change Password</h3>
                <form onsubmit="event.preventDefault(); alert('Password updated successfully!');" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Current Password</label>
                        <input type="password" placeholder="••••••••" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">New Password</label>
                        <input type="password" placeholder="••••••••" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: fit-content;">Update Password</button>
                </form>
            </div>
        </div>

        <!-- Panel 2: Orders & Order Tracking -->
        <div id="panel-orders" class="dash-panel" style="display: none;">
            @php
                $orders = auth()->user()->orders;
                $latestOrder = $orders->first();
            @endphp

            @if($orders->isEmpty())
                <div class="glass" style="border-radius: var(--radius-md); padding: 4rem; text-align: center; border: 1px solid var(--border-color);">
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">No orders placed yet</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">When you purchase items from our boutique, your shipment details will appear here.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            @else
                <!-- Active Tracker for Latest Order -->
                <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color); margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <span style="font-weight: 700; font-size: 1.1rem;">Latest Order #{{ $latestOrder->order_number }}</span>
                            <div style="font-size: 0.85rem; color: var(--text-secondary);">Placed on {{ $latestOrder->created_at->format('F d, Y') }}</div>
                        </div>
                        <span style="background: rgba(255, 107, 0, 0.15); color: var(--primary); padding: 0.35rem 1rem; border-radius: 50px; font-weight: 700; font-size: 0.85rem;">{{ $latestOrder->status }}</span>
                    </div>

                    @php
                        $progress = 0;
                        if($latestOrder->status == 'Packed') $progress = 33;
                        elseif($latestOrder->status == 'Shipped') $progress = 66;
                        elseif($latestOrder->status == 'Delivered') $progress = 100;
                    @endphp

                    <!-- Live Tracking Stepper -->
                    <div style="display: flex; justify-content: space-between; position: relative; margin: 2rem 0;">
                        <div style="position: absolute; top: 14px; left: 10%; right: 10%; height: 4px; background: var(--border-color); z-index: 1;"></div>
                        <div style="position: absolute; top: 14px; left: 10%; width: {{ $progress * 0.8 }}%; height: 4px; background: var(--primary); z-index: 2; transition: width 0.4s ease;"></div>

                        <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">✓</div>
                            <span style="font-size: 0.85rem; font-weight: 700; margin-top: 0.5rem;">Confirmed</span>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $progress >= 33 ? 'var(--primary)' : 'var(--light-grey)' }}; color: {{ $progress >= 33 ? 'white' : 'var(--text-secondary)' }}; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; border: {{ $progress >= 33 ? 'none' : '1px solid var(--border-color)' }};">
                                {{ $progress >= 33 ? '✓' : '2' }}
                            </div>
                            <span style="font-size: 0.85rem; font-weight: {{ $progress >= 33 ? '700' : '500' }}; margin-top: 0.5rem; color: {{ $progress >= 33 ? 'var(--text-primary)' : 'var(--text-secondary)' }};">Packed</span>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $progress >= 66 ? 'var(--primary)' : 'var(--light-grey)' }}; color: {{ $progress >= 66 ? 'white' : 'var(--text-secondary)' }}; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; border: {{ $progress >= 66 ? 'none' : '1px solid var(--border-color)' }};">
                                {{ $progress >= 66 ? '✓' : '🚚' }}
                            </div>
                            <span style="font-size: 0.85rem; font-weight: {{ $progress >= 66 ? '700' : '500' }}; margin-top: 0.5rem; color: {{ $progress >= 66 ? 'var(--text-primary)' : 'var(--text-secondary)' }};">Shipped</span>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $progress >= 100 ? 'var(--primary)' : 'var(--light-grey)' }}; color: {{ $progress >= 100 ? 'white' : 'var(--text-secondary)' }}; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; border: {{ $progress >= 100 ? 'none' : '1px solid var(--border-color)' }};">
                                {{ $progress >= 100 ? '✓' : '🏠' }}
                            </div>
                            <span style="font-size: 0.85rem; font-weight: {{ $progress >= 100 ? '700' : '500' }}; margin-top: 0.5rem; color: {{ $progress >= 100 ? 'var(--text-primary)' : 'var(--text-secondary)' }};">Delivered</span>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                        <a href="{{ route('track.order') }}?id={{ $latestOrder->order_number }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Track Package</a>
                        <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="alert('Help request submitted! VIP agent will email you shortly.')">Request Help</button>
                    </div>
                </div>

                <!-- Past Order List -->
                <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color);">
                    <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem;">Order History</h4>
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        @foreach($orders as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
                                <div>
                                    <span style="font-weight: 600; font-size: 0.95rem;">Order #{{ $item->order_number }}</span>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary);">Placed on {{ $item->created_at->format('M d, Y') }}</div>
                                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 0.25rem;">
                                        Items: 
                                        @foreach($item->items as $prod)
                                            {{ $prod['name'] }} (x{{ $prod['qty'] }}){{ !$loop->last ? ',' : '' }}
                                        @endforeach
                                    </div>
                                </div>
                                <span style="font-weight: 700; color: #10B981; font-size: 0.9rem;">₹{{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        </div>

        <!-- Panel 3: Wishlist (Dynamic localstorage synced cards) -->
        <div id="panel-wishlist" class="dash-panel" style="display: none;">
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">My Wishlist</h3>
            <div id="dash-wishlist-grid" class="grid-container">
                <!-- Rendered dynamically via JS -->
            </div>
        </div>

        <!-- Panel 4: Saved Addresses -->
        <div id="panel-addresses" class="dash-panel" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.5rem; font-weight: 800;">Saved Addresses</h3>
                <button class="btn btn-primary" onclick="alert('Add address modal!')" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Add New Address</button>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="glass" style="border-radius: var(--radius-md); padding: 1.5rem; border: 1px solid var(--border-color); relative: position;">
                    <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.5rem;">Primary Home</span>
                    <h4 style="font-weight: 700; font-size: 1rem; margin-bottom: 0.25rem;">John Doe</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5;">123 Luxury Lane<br>Beverly Hills, CA 90210<br>United States</p>
                </div>
            </div>
        </div>

        <!-- Panel 5: Notifications & Reviews Feed -->
        <div id="panel-notifications" class="dash-panel" style="display: none;">
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Notifications</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div class="glass" style="border-radius: var(--radius-md); padding: 1.25rem; border: 1px solid var(--border-color); display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="background: rgba(255,107,0,0.15); color: var(--primary); padding: 0.5rem; border-radius: 50%;">🔔</div>
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.25rem;">VIP Early Access is Live!</h4>
                        <p style="font-size: 0.85rem; color: var(--text-secondary);">Your membership gives you early access to the upcoming Summer Horology series.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchDashTab(tabId, btn) {
        document.querySelectorAll('.dash-panel').forEach(p => p.style.display = 'none');
        document.querySelectorAll('.dash-tab-btn').forEach(b => b.classList.remove('active'));

        const panel = document.getElementById('panel-' + tabId);
        if(panel) panel.style.display = 'block';
        if(btn) btn.classList.add('active');
    }

    // Load wishlist items inside user dashboard
    window.loadDashboardWishlist = function() {
        const grid = document.getElementById('dash-wishlist-grid');
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

        if (wishlist.length === 0) {
            grid.innerHTML = `
                <div class="glass" style="grid-column: span 3; border-radius: var(--radius-md); padding: 3rem; text-align: center; border: 1px solid var(--border-color); width: 100%;">
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Your wishlist is empty.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Find Products</a>
                </div>
            `;
            return;
        }

        grid.innerHTML = wishlist.map(item => `
            <div class="product-card" id="wish-item-${item.id}">
                <div class="product-img-wrapper">
                    <button class="product-wishlist-btn" onclick="toggleWishlist(${item.id}, '${item.name}', ${item.price}, '${item.img}'); loadDashboardWishlist();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    </button>
                    <img src="${item.img}">
                </div>
                <div class="product-info">
                    <a href="/product/${item.id}" class="product-title">${item.name}</a>
                    <div class="product-footer">
                        <span class="product-price">₹${item.price.toFixed(2)}</span>
                        <button class="add-to-cart-btn" onclick="addToCart(${item.id}, '${item.name}', ${item.price}, '${item.img}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    };

    // Auto-check if tab URL parameter exists
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('tab') === 'wishlist') {
        const wishlistBtn = document.querySelector('[onclick*="wishlist"]');
        if(wishlistBtn) wishlistBtn.click();
    }
</script>
@endsection
