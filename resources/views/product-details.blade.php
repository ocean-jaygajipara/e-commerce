@extends('layouts.storefront')

@php
    $product = \App\Models\Product::find($id) ?? \App\Models\Product::first();
@endphp

@section('title')
    {{ $product->name }} - VELOX
@endsection

@section('content')
<div style="margin-top: 2rem;">
    <!-- Breadcrumbs -->
    <div style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 2rem;">
        <a href="{{ route('home') }}" style="color: inherit; text-decoration: none;">Home</a> /
        <a href="{{ route('shop') }}" style="color: inherit; text-decoration: none;">Shop</a> /
        <span style="color: var(--text-primary); font-weight: 600;">{{ $product->name }}</span>
    </div>

    <!-- Product Details Main Info Section -->
    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 4rem; margin-bottom: 4rem;">
        <!-- Left: Image Gallery & Zoom Mock -->
        <div>
            <div style="position: relative; overflow: hidden; border-radius: var(--radius-lg); background: var(--light-grey); margin-bottom: 1rem; cursor: zoom-in;" 
                 onmousemove="zoomImage(event)" onmouseleave="resetZoom()">
                <img id="main-product-img" src="{{ $product->img }}" 
                     style="width: 100%; height: 500px; object-fit: cover; transition: transform 0.1s ease; transform-origin: center center;">
            </div>
            <!-- Thumbnails -->
            <div style="display: flex; gap: 1rem;">
                <div style="width: 80px; height: 80px; border-radius: var(--radius-sm); overflow: hidden; border: 2px solid var(--primary); cursor: pointer;" onclick="changeImg('{{ $product->img }}', this)">
                    <img src="{{ $product->img }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- Right: Product Information & Purchase options -->
        <div style="display: flex; flex-direction: column; justify-content: center;">
            <span style="color: var(--primary); font-weight: 700; font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase;">{{ $product->brand }}</span>
            <h1 style="font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0 1rem;">{{ $product->name }}</h1>
            
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="color: #FFB800;">★★★★★ <span style="color: var(--text-primary); font-weight: 600; margin-left: 0.25rem;">{{ $product->rating }}</span></div>
                <span style="color: var(--text-secondary); font-size: 0.9rem;">({{ $product->reviews_count }} Reviews)</span>
                <span style="border-left: 1px solid var(--border-color); height: 16px;"></span>
                <span style="color: #10B981; font-weight: 700; font-size: 0.9rem;">In Stock ({{ $product->stock }} units left)</span>
            </div>

            <div style="display: flex; align-items: baseline; gap: 1rem; margin-bottom: 2rem;">
                <span style="font-size: 2.25rem; font-weight: 800; color: var(--text-primary);">₹{{ number_format($product->price, 2) }}</span>
            </div>

            <p style="color: var(--text-secondary); line-height: 1.6; margin-bottom: 2rem;">{{ $product->description }}</p>

            <!-- Quantity Selector & Action buttons -->
            <div style="display: flex; gap: 1rem; margin-bottom: 2rem; align-items: center;">
                <div style="display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 0.5rem 1rem; background: var(--light-grey);">
                    <button onclick="changeDetailQty(-1)" style="border: none; background: none; font-size: 1.25rem; cursor: pointer; color: var(--text-primary);">-</button>
                    <span id="detail-qty" style="padding: 0 1.25rem; font-weight: 700; font-size: 1.1rem;">1</span>
                    <button onclick="changeDetailQty(1)" style="border: none; background: none; font-size: 1.25rem; cursor: pointer; color: var(--text-primary);">+</button>
                </div>
                <button class="btn btn-primary" style="flex-grow: 1; padding: 1.1rem;" onclick="addDetailToCart()">Add to Bag</button>
                <button class="btn btn-secondary" style="padding: 1.1rem 2rem;" onclick="handleBuyNow()">Buy Now</button>
            </div>

            <!-- Pincode Delivery Check Widget -->
            <div style="margin: 2rem 0; padding: 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: rgba(0,0,0,0.02);">
                <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 0.5rem; letter-spacing: 1px;">Delivery Check</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" id="pincode-input" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);" placeholder="Enter Pincode (e.g. 360001)" style="flex-grow: 1; padding: 0.6rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); outline: none; font-size: 0.9rem; background: var(--white); color: var(--text-primary);">
                    <button onclick="checkPincodeEstimate()" class="btn btn-primary" style="padding: 0.6rem 1.25rem; font-size: 0.85rem; width: fit-content;">Check</button>
                </div>
                <div id="pincode-result" style="margin-top: 0.75rem; font-size: 0.85rem; font-weight: 600; display: none;"></div>
            </div>

            <div style="display: flex; gap: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <button style="background:none; border:none; display:flex; align-items:center; gap:0.5rem; color:var(--text-primary); cursor:pointer; font-weight: 600;" onclick="toggleWishlist({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->img }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    Add to Wishlist
                </button>
            </div>
        </div>
    </div>

    <!-- Details Tab Section (Specs, Description, Delivery) -->
    <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); margin-bottom: 4rem;">
        <div style="display: flex; border-bottom: 1px solid var(--border-color);">
            <button class="detail-tab active" onclick="switchDetailTab('desc', this)" style="padding: 1.25rem 2rem; font-weight: 700; font-size: 1rem; border: none; background: none; cursor: pointer; border-bottom: 3px solid var(--primary); color: var(--text-primary);">Description</button>
            <button class="detail-tab" onclick="switchDetailTab('specs', this)" style="padding: 1.25rem 2rem; font-weight: 600; font-size: 1rem; border: none; background: none; cursor: pointer; border-bottom: 3px solid transparent; color: var(--text-secondary);">Specifications</button>
            <button class="detail-tab" onclick="switchDetailTab('delivery', this)" style="padding: 1.25rem 2rem; font-weight: 600; font-size: 1rem; border: none; background: none; cursor: pointer; border-bottom: 3px solid transparent; color: var(--text-secondary);">Delivery Options</button>
        </div>
        <div style="padding: 2.5rem;">
            <!-- Description Tab -->
            <div id="tab-desc" class="detail-tab-content">
                <h3 style="font-weight: 700; margin-bottom: 1rem;">Experience distinction.</h3>
                <p style="color: var(--text-secondary); line-height: 1.7; margin-bottom: 1rem;">{{ $product->description }}</p>
            </div>
            <!-- Specs Tab -->
            <div id="tab-specs" class="detail-tab-content" style="display: none;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 0.75rem 0; font-weight: 600; width: 30%;">Brand</td>
                        <td style="padding: 0.75rem 0; color: var(--text-secondary);">{{ $product->brand }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 0.75rem 0; font-weight: 600; width: 30%;">Category</td>
                        <td style="padding: 0.75rem 0; color: var(--text-secondary);">{{ $product->category->name }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 0.75rem 0; font-weight: 600; width: 30%;">Stock Status</td>
                        <td style="padding: 0.75rem 0; color: var(--text-secondary);">{{ $product->stock }} units available</td>
                    </tr>
                </table>
            </div>
            <!-- Delivery Tab -->
            <div id="tab-delivery" class="detail-tab-content" style="display: none;">
                <h3 style="font-weight: 700; margin-bottom: 1rem;">Secure Worldwide Shipping</h3>
                <p style="color: var(--text-secondary); line-height: 1.7; margin-bottom: 1rem;">All packages are shipped in high-end, discreet gift boxes. Standard local delivery takes 2-4 business days. Express overnight shipping options are available at checkout.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab switching
    function switchDetailTab(tabId, btn) {
        document.querySelectorAll('.detail-tab-content').forEach(content => content.style.display = 'none');
        document.querySelectorAll('.detail-tab').forEach(tab => {
            tab.style.color = 'var(--text-secondary)';
            tab.style.borderBottomColor = 'transparent';
        });

        document.getElementById('tab-' + tabId).style.display = 'block';
        btn.style.color = 'var(--text-primary)';
        btn.style.borderBottomColor = 'var(--primary)';
    }

    // Thumbnail click image replacement
    function changeImg(src, borderWrapper) {
        document.getElementById('main-product-img').src = src;
        borderWrapper.parentNode.querySelectorAll('div').forEach(thumb => {
            thumb.style.borderColor = 'transparent';
        });
        borderWrapper.style.borderColor = 'var(--primary)';
    }

    // Zoom effect on hover
    function zoomImage(e) {
        const img = document.getElementById('main-product-img');
        const zoomer = e.currentTarget;
        const rect = zoomer.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const xPercent = (x / rect.width) * 100;
        const yPercent = (y / rect.height) * 100;
        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        img.style.transform = 'scale(1.8)';
    }

    function resetZoom() {
        const img = document.getElementById('main-product-img');
        img.style.transform = 'scale(1)';
        img.style.transformOrigin = 'center center';
    }

    // Quantity selector
    let qty = 1;
    function changeDetailQty(delta) {
        qty = Math.max(1, qty + delta);
        document.getElementById('detail-qty').innerText = qty;
    }

    function addDetailToCart() {
        addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->img }}', qty);
    }

    let isPincodeChecked = false;

    function checkPincodeEstimate() {
        const pincode = document.getElementById('pincode-input').value.trim();
        const resultDiv = document.getElementById('pincode-result');
        if (!pincode || pincode.length < 6 || isNaN(pincode)) {
            resultDiv.style.color = '#EF4444';
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '✕ Please enter a valid 6-digit Pincode.';
            isPincodeChecked = false;
            return;
        }

        const days = parseInt(pincode[0]) % 3 + 2; // Mock delivery days
        const date = new Date();
        date.setDate(date.getDate() + days);
        const options = { weekday: 'long', month: 'short', day: 'numeric' };
        const deliveryDateStr = date.toLocaleDateString('en-US', options);

        resultDiv.style.color = '#10B981';
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `🚚 Delivery expected by <strong>${deliveryDateStr}</strong> (${days} days delivery).`;
        isPincodeChecked = true;
    }

    function handleBuyNow() {
        if (!isPincodeChecked) {
            window.showToast("Please enter and check a valid Pincode before proceeding.", "error");
            document.getElementById('pincode-input').focus();
            return;
        }
        location.href = '{{ route("checkout") }}';
    }
</script>
@endsection
