@extends('layouts.storefront')

@section('title', 'User Dashboard - VELOX')

@section('content')
<div style="margin-top: 2rem; min-height: 600px; width: 100%;">
    <!-- Right Dashboard Panels -->
    <div style="width: 100%;">
        <!-- Panel 1: Profile & Edit Profile & Change Password -->
        <div id="panel-profile" class="dash-panel">
            <div class="glass" style="border-radius: var(--radius-md); padding: 2.5rem; border: 1px solid var(--border-color); margin-bottom: 2rem;">
                <form id="profile-info-form" onsubmit="saveProfileInfo(event)" style="display: flex; flex-direction: column; gap: 2rem;">
                    @php
                        $nameParts = explode(' ', auth()->user()->name, 2);
                        $firstName = $nameParts[0] ?? '';
                        $lastName = $nameParts[1] ?? '';
                    @endphp

                    <!-- Personal Info Section -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <h4 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--text-primary);">Personal Information</h4>
                            <span style="color: var(--primary); font-weight: 600; font-size: 0.85rem; cursor: pointer;">Edit</span>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.25rem;">
                            <input type="text" id="profile-first-name" value="{{ $firstName }}" placeholder="First Name" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                            <input type="text" id="profile-last-name" value="{{ $lastName }}" placeholder="Last Name" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                        </div>
                        <div>
                            <span style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Your Gender</span>
                            <div style="display: flex; gap: 1.5rem; align-items: center;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer; color: var(--text-primary);">
                                    <input type="radio" name="gender" value="male" checked style="accent-color: var(--primary);"> Male
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer; color: var(--text-primary);">
                                    <input type="radio" name="gender" value="female" style="accent-color: var(--primary);"> Female
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Email Section -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <h4 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--text-primary);">Email Address</h4>
                            <span style="color: var(--primary); font-weight: 600; font-size: 0.85rem; cursor: pointer;">Edit</span>
                        </div>
                        <div style="max-width: 50%;">
                            <input type="email" id="profile-email" value="{{ auth()->user()->email }}" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                        </div>
                    </div>

                    <!-- Mobile Section -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <h4 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--text-primary);">Mobile Number</h4>
                            <span style="color: var(--primary); font-weight: 600; font-size: 0.85rem; cursor: pointer;">Edit</span>
                        </div>
                        <div style="max-width: 50%;">
                            <input type="text" id="profile-mobile" placeholder="+91 9999999999" style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary" style="width: fit-content;">Save Changes</button>
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
            @endphp

            @if($orders->isEmpty())
                <div class="glass" style="border-radius: var(--radius-md); padding: 4rem; text-align: center; border: 1px solid var(--border-color);">
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">No orders placed yet</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">When you purchase items from our boutique, your shipment details will appear here.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            @else
                <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color);">
                    <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--text-primary);">My Orders</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @foreach($orders as $item)
                            <div class="glass" style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); overflow: hidden;">
                                <!-- Order Header Row -->
                                <div onclick="location.href='{{ route('track.order') }}?id={{ $item->order_number }}'" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; background: rgba(0,0,0,0.02); cursor: pointer; transition: var(--transition);" onmouseover="this.style.background='rgba(0,0,0,0.05)';" onmouseout="this.style.background='rgba(0,0,0,0.02)';">
                                    <div style="display: flex; align-items: center; gap: 1.25rem;">
                                        @php
                                            $firstItem = collect($item->items)->first();
                                            $imgUrl = $firstItem['img'] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=150';
                                        @endphp
                                        <div style="width: 50px; height: 50px; border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--border-color); background: white;">
                                            <img src="{{ $imgUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div>
                                            <span style="font-weight: 700; font-size: 1rem; color: var(--text-primary);">Order #{{ $item->order_number }}</span>
                                            <span style="background: rgba(255, 107, 0, 0.15); color: var(--primary); padding: 0.25rem 0.75rem; border-radius: 50px; font-weight: 700; font-size: 0.8rem; margin-left: 0.75rem;">{{ $item->status }}</span>
                                            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.25rem;">Placed on {{ $item->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                                        <span style="font-weight: 800; color: var(--text-primary); font-size: 1rem;">₹{{ number_format($item->total, 2) }}</span>
                                        <span style="color: var(--primary); font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 0.25rem;">Details →</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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
            <div class="glass" style="border-radius: var(--radius-md); padding: 2.5rem; border: 1px solid var(--border-color);">
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Default Shipping Address</h3>
                <form id="address-form" onsubmit="saveAddress(event)" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Full Name</label>
                        <input type="text" id="addr-fullname" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Address Line 1</label>
                        <input type="text" id="addr-line1" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">City</label>
                        <input type="text" id="addr-city" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">ZIP / Postal Code</label>
                        <input type="text" id="addr-pincode" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 2;">
                        <button type="submit" class="btn btn-primary" style="width: fit-content;">Save Address</button>
                    </div>
                </form>
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
    function switchDashTab(tabId) {
        document.querySelectorAll('.dash-panel').forEach(p => p.style.display = 'none');
        const panel = document.getElementById('panel-' + tabId);
        if(panel) panel.style.display = 'block';
        if(tabId === 'wishlist') {
            loadDashboardWishlist();
        }
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
    const activeTab = "{{ $activeTab ?? 'profile' }}";
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab') || activeTab;
    switchDashTab(tabParam);

    function loadAddress() {
        const dbAddr = {
            fullname: "{{ auth()->user()->fullname ?? '' }}",
            line1: "{{ auth()->user()->address ?? '' }}",
            city: "{{ auth()->user()->city ?? '' }}",
            pincode: "{{ auth()->user()->pincode ?? '' }}"
        };
        if (dbAddr.fullname || dbAddr.line1) {
            document.getElementById('addr-fullname').value = dbAddr.fullname;
            document.getElementById('addr-line1').value = dbAddr.line1;
            document.getElementById('addr-city').value = dbAddr.city;
            document.getElementById('addr-pincode').value = dbAddr.pincode;
        }
    }

    async function saveAddress(e) {
        e.preventDefault();
        const formData = new FormData();
        formData.append('fullname', document.getElementById('addr-fullname').value.trim());
        formData.append('address', document.getElementById('addr-line1').value.trim());
        formData.append('city', document.getElementById('addr-city').value.trim());
        formData.append('pincode', document.getElementById('addr-pincode').value.trim());
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const response = await fetch('/api/user/address', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.success) {
                window.showToast(data.message, "success");
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                window.showToast(data.message || "Failed to save address.", "error");
            }
        } catch (error) {
            window.showToast("An error occurred while saving the address.", "error");
        }
    }

    function returnOrder(orderId) {
        document.getElementById('return-order-id').value = orderId;
        document.getElementById('return-reason-select').value = '';
        document.getElementById('return-comment-text').value = '';
        document.getElementById('return-modal').style.display = 'flex';
    }

    function closeReturnModal() {
        document.getElementById('return-modal').style.display = 'none';
    }

    function submitReturnRequest(e) {
        e.preventDefault();
        const orderId = document.getElementById('return-order-id').value;
        const reason = document.getElementById('return-reason-select').value;
        const comment = document.getElementById('return-comment-text').value;

        fetch(`/order/${orderId}/return`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ reason, comment })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                closeReturnModal();
                window.showToast("Return request submitted successfully!", "success");
                setTimeout(() => location.reload(), 1500);
            } else {
                window.showToast(data.message || "Failed to submit return request.", "error");
            }
        })
        .catch(err => {
            window.showToast("An error occurred.", "error");
        });
    }

    function loadProfileInfo() {
        const gender = localStorage.getItem('profile_gender') || 'male';
        const mobile = localStorage.getItem('profile_mobile') || '';
        
        const radio = document.querySelector(`input[name="gender"][value="${gender}"]`);
        if(radio) radio.checked = true;
        
        document.getElementById('profile-mobile').value = mobile;
    }

    function saveProfileInfo(e) {
        e.preventDefault();
        const gender = document.querySelector('input[name="gender"]:checked').value;
        const mobile = document.getElementById('profile-mobile').value.trim();
        
        localStorage.setItem('profile_gender', gender);
        localStorage.setItem('profile_mobile', mobile);
        
        window.showToast("Personal information updated successfully!", "success");
    }

    function toggleOrderDetails(orderId) {
        const details = document.getElementById(`order-details-${orderId}`);
        const chevron = document.getElementById(`order-chevron-${orderId}`);
        if (!details) return;
        details.classList.toggle('open');
        if (details.classList.contains('open')) {
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        } else {
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }
    }

    function populateOrderAddresses() {
        const dbAddr = {
            fullname: "{{ auth()->user()->fullname ?? '' }}",
            line1: "{{ auth()->user()->address ?? '' }}",
            city: "{{ auth()->user()->city ?? '' }}",
            pincode: "{{ auth()->user()->pincode ?? '' }}"
        };
        if (dbAddr.fullname) {
            const addrText = `${dbAddr.fullname}<br>${dbAddr.line1}, ${dbAddr.city} - ${dbAddr.pincode}`;
            document.querySelectorAll('[id^="order-addr-"]').forEach(el => {
                el.innerHTML = addrText;
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadAddress();
        loadProfileInfo();
        populateOrderAddresses();

        // Pin Code Auto-Fill API Listener
        const pinInput = document.getElementById('addr-pincode');
        if (pinInput) {
            pinInput.addEventListener('input', function(e) {
                const pincode = e.target.value.trim();
                if (pincode.length === 6 && !isNaN(pincode)) {
                    fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data[0] && data[0].Status === 'Success') {
                                const postOffice = data[0].PostOffice[0];
                                const city = postOffice.District || postOffice.Block;
                                if (city) {
                                    document.getElementById('addr-city').value = city;
                                    window.showToast(`Autofilled City: ${city}`, "success");
                                }
                            }
                        })
                        .catch(err => console.log('PIN code fetch failed', err));
                }
            });
        }
    });
</script>

<!-- Select2 Assets & custom styles -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .order-details-pane {
        display: none;
    }
    .order-details-pane.open {
        display: block !important;
    }
    .select2-container--default .select2-selection--single {
        height: auto !important;
        padding: 0.6rem 0.75rem !important;
        border-radius: var(--radius-sm) !important;
        border: 1px solid var(--border-color) !important;
        background: var(--white) !important;
        font-family: 'Outfit', sans-serif !important;
        outline: none !important;
        box-sizing: border-box !important;
        display: block !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--text-primary) !important;
        line-height: 1.5 !important;
        padding-left: 0 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        top: 0 !important;
        right: 12px !important;
    }
    .select2-dropdown {
        border-radius: var(--radius-sm) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: var(--shadow-md) !important;
        font-family: 'Outfit', sans-serif !important;
        background: var(--white) !important;
        z-index: 100000 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary) !important;
        color: white !important;
    }
    .select2-container {
        width: 100% !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#return-reason-select').select2({
            dropdownParent: $('#return-modal'),
            minimumResultsForSearch: Infinity // Hides the search bar to keep it clean like standard dropdown
        });
    });
</script>

<!-- Return Request Modal -->
<div id="return-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 9999; justify-content: center; align-items: center;">
    <div class="glass" style="width: 100%; max-width: 500px; padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: var(--white); box-shadow: var(--shadow-lg);">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--text-primary);">Return Request</h3>
        <form id="return-form" onsubmit="submitReturnRequest(event)">
            <input type="hidden" id="return-order-id" value="">
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-secondary);">Reason for Return</label>
                <select id="return-reason-select" required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary); outline: none;">
                    <option value="">-- Select a Reason --</option>
                    <option value="Quality of the product not as expected">Quality of the product not as expected</option>
                    <option value="Received a broken/damaged item">Received a broken/damaged item</option>
                    <option value="Item was different from what was ordered">Item was different from what was ordered</option>
                    <option value="Wrong size/fit">Wrong size/fit</option>
                    <option value="Other reasons">Other reasons</option>
                </select>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-secondary);">Comments / Details (Optional)</label>
                <textarea id="return-comment-text" placeholder="Please provide additional details about the issue..." style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary); outline: none; height: 100px; resize: none; box-sizing: border-box;"></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" class="btn btn-secondary" onclick="closeReturnModal()" style="padding: 0.6rem 1.25rem; font-size: 0.85rem; width: fit-content;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.25rem; font-size: 0.85rem; background: #EF4444; border-color: #EF4444; width: fit-content;">Submit Return</button>
            </div>
        </form>
    </div>
</div>
@endsection
