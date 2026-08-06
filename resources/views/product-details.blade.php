@extends('layouts.storefront')

@php
    $product = \App\Models\Product::where('slug', $slug)->first() ?? \App\Models\Product::first();
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

            @if($product->colors && count($product->colors) > 0)
            <!-- Color Selector Option -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 0.75rem; letter-spacing: 1px;">Select Color</label>
                <div style="display: flex; gap: 0.75rem;" id="product-color-selector">
                    @foreach($product->colors as $index => $color)
                        @php
                            $isObj = is_array($color);
                            $cName = $isObj ? ($color['name'] ?? '') : $color;
                            $cCode = $isObj ? ($color['code'] ?? '') : $color;
                            $cStock = $isObj ? intval($color['stock'] ?? 0) : $product->stock;
                        @endphp
                        <div class="color-option {{ $index == 0 ? 'active' : '' }} {{ $cStock <= 0 ? 'out-of-stock' : '' }}" 
                             data-color-name="{{ $cName }}" 
                             data-color-code="{{ $cCode }}" 
                             data-stock="{{ $cStock }}" 
                             style="width: 32px; height: 32px; border-radius: 50%; background: {{ $cCode }}; border: {{ $index == 0 ? '2px solid var(--primary)' : '1px solid var(--border-color)' }}; cursor: pointer; transition: all 0.2s; position: relative; {{ $cStock <= 0 ? 'opacity: 0.25; cursor: not-allowed;' : '' }}" 
                             onclick="{{ $cStock <= 0 ? '' : 'selectColor(this)' }}">
                             @if($cStock <= 0)
                                <div style="position: absolute; top: 50%; left: 50%; width: 100%; height: 2px; background: #EF4444; transform: translate(-50%, -50%) rotate(45deg);"></div>
                             @endif
                        </div>
                    @endforeach
                </div>
                <span id="selected-color-label" style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 0.5rem; display: block; font-weight: 600;">Selected: <span style="color: var(--text-primary);" id="active-color-name">Default</span> <span style="font-size: 0.8rem; color: #10B981; margin-left: 0.5rem;" id="active-color-stock"></span></span>
            </div>
            @endif

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

    <!-- Details Section (Specs, Description, Delivery stacked) -->
    <div style="display: flex; flex-direction: column; gap: 2rem; margin-bottom: 4rem;">
        <!-- Description Section -->
        <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2.5rem;">
            <h3 style="font-weight: 700; margin-bottom: 1rem; border-bottom: 2px solid var(--primary); width: fit-content; padding-bottom: 0.5rem;">Description</h3>
            <h4 style="font-weight: 600; margin-bottom: 1rem; margin-top: 1rem;">Experience distinction.</h4>
            <p style="color: var(--text-secondary); line-height: 1.7; margin-bottom: 1rem;">{{ $product->description }}</p>
        </div>

        <!-- Specs Section -->
        <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2.5rem;">
            <h3 style="font-weight: 700; margin-bottom: 1rem; border-bottom: 2px solid var(--primary); width: fit-content; padding-bottom: 0.5rem;">Specifications</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
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

        <!-- Delivery Section -->
        <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2.5rem;">
            <h3 style="font-weight: 700; margin-bottom: 1rem; border-bottom: 2px solid var(--primary); width: fit-content; padding-bottom: 0.5rem;">Delivery Options</h3>
            <h4 style="font-weight: 600; margin-bottom: 1rem; margin-top: 1rem;">Secure Worldwide Shipping</h4>
            <p style="color: var(--text-secondary); line-height: 1.7; margin-bottom: 1rem;">All packages are shipped in high-end, discreet gift boxes. Standard local delivery takes 2-4 business days. Express overnight shipping options are available at checkout.</p>
        </div>

        <!-- Reviews Section -->
        @php
            $reviews = $product->reviews()->with('user')->latest()->get();
            
            $hasDeliveredOrder = false;
            $hasAlreadyReviewed = false;
            if (auth()->check()) {
                $deliveredOrders = \App\Models\Order::where('user_id', auth()->id())
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
                
                $hasAlreadyReviewed = \App\Models\Review::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->exists();
            }
        @endphp
        <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2.5rem;">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; border-bottom: 2px solid var(--primary); width: fit-content; padding-bottom: 0.5rem;">Customer Reviews</h3>
            
            <!-- List of existing reviews -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 2.5rem;">
                @if($reviews->isEmpty())
                    <p style="color: var(--text-secondary); font-style: italic;">No reviews yet. Be the first to share your thoughts!</p>
                @else
                    @foreach($reviews as $rev)
                        <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <strong style="font-size: 1rem; color: var(--text-primary);">{{ $rev->user->name }}</strong>
                                <span style="font-size: 0.85rem; color: var(--text-secondary);">{{ $rev->created_at->format('M d, Y') }}</span>
                            </div>
                            <div style="color: #FFB800; margin-bottom: 0.5rem;">
                                {{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}
                            </div>
                            <p style="color: var(--text-secondary); line-height: 1.6; margin: 0;">{{ $rev->comment }}</p>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Review submission form -->
            @auth
                @if($hasDeliveredOrder)
                    @if($hasAlreadyReviewed)
                        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10B981; border-radius: var(--radius-sm); padding: 1rem; color: #10B981; font-weight: 600;">
                            ✓ You have already submitted a review for this product. Thank you!
                        </div>
                    @else
                        <div style="border-top: 1px solid var(--border-color); padding-top: 2rem;">
                            <h4 style="font-weight: 700; margin-bottom: 1rem;">Write a Review</h4>
                            <form id="review-form" onsubmit="handleReviewSubmit(event)" style="display: flex; flex-direction: column; gap: 1.25rem;">
                                @csrf
                                <div>
                                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">Rating</label>
                                    <div style="display: flex; gap: 0.5rem; font-size: 1.75rem; color: #D1D5DB; cursor: pointer;">
                                        <span class="star-rating" data-value="1" onclick="setRating(1)" onmouseover="highlightStars(1)" onmouseout="resetStars()">★</span>
                                        <span class="star-rating" data-value="2" onclick="setRating(2)" onmouseover="highlightStars(2)" onmouseout="resetStars()">★</span>
                                        <span class="star-rating" data-value="3" onclick="setRating(3)" onmouseover="highlightStars(3)" onmouseout="resetStars()">★</span>
                                        <span class="star-rating" data-value="4" onclick="setRating(4)" onmouseover="highlightStars(4)" onmouseout="resetStars()">★</span>
                                        <span class="star-rating" data-value="5" onclick="setRating(5)" onmouseover="highlightStars(5)" onmouseout="resetStars()">★</span>
                                    </div>
                                    <input type="hidden" name="rating" id="review-rating-input" required>
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">Your Comment</label>
                                    <textarea name="comment" required placeholder="Share your experience with this premium product..." style="width: 100%; height: 120px; padding: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary); outline: none; font-size: 0.95rem; resize: vertical;"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: fit-content; padding: 0.75rem 2rem;">Submit Review</button>
                            </form>
                        </div>
                    @endif
                @else
                    <div style="background: rgba(239, 68, 68, 0.05); border: 1px solid #EF4444; border-radius: var(--radius-sm); padding: 1rem; color: #EF4444; font-size: 0.9rem; font-weight: 600;">
                        ⚠ Only customers who have purchased this product and received it (Delivered status) can write a review.
                    </div>
                @endif
            @else
                <div style="background: rgba(0,0,0,0.02); border: 1px dashed var(--border-color); border-radius: var(--radius-sm); padding: 1.25rem; text-align: center; color: var(--text-secondary);">
                    Please <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Login</a> to submit a review.
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

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

    let selectedColor = 'Default';
    let selectedColorStock = {{ $product->stock }};

    // Initialize active color on load
    document.addEventListener('DOMContentLoaded', () => {
        const options = document.querySelectorAll('.color-option');
        let firstInStock = null;
        options.forEach(opt => {
            if (!opt.classList.contains('out-of-stock') && !firstInStock) {
                firstInStock = opt;
            }
        });

        if (firstInStock) {
            options.forEach(o => {
                o.classList.remove('active');
                o.style.border = '1px solid var(--border-color)';
            });
            firstInStock.classList.add('active');
            firstInStock.style.border = '2px solid var(--primary)';
            selectedColor = firstInStock.getAttribute('data-color-name');
            selectedColorStock = parseInt(firstInStock.getAttribute('data-stock'));
            document.getElementById('active-color-name').innerText = selectedColor;
            document.getElementById('active-color-stock').innerText = `(${selectedColorStock} units left)`;
        } else if (options.length > 0) {
            selectedColorStock = 0;
            qty = 0;
            document.getElementById('detail-qty').innerText = qty;
            document.getElementById('active-color-name').innerText = 'None';
            document.getElementById('active-color-stock').innerText = `(Out of Stock)`;
            document.getElementById('active-color-stock').style.color = '#EF4444';
        } else {
            // Fallback for products without colors
            document.getElementById('active-color-stock').innerText = `(${selectedColorStock} units left)`;
        }
    });

    window.selectColor = function(element) {
        document.querySelectorAll('.color-option').forEach(el => {
            el.classList.remove('active');
            el.style.border = '1px solid var(--border-color)';
        });
        element.classList.add('active');
        element.style.border = '2px solid var(--primary)';
        selectedColor = element.getAttribute('data-color-name');
        selectedColorStock = parseInt(element.getAttribute('data-stock'));
        document.getElementById('active-color-name').innerText = selectedColor;
        document.getElementById('active-color-stock').innerText = `(${selectedColorStock} units left)`;
        document.getElementById('active-color-stock').style.color = '#10B981';

        if (qty > selectedColorStock) {
            qty = selectedColorStock > 0 ? 1 : 0;
            document.getElementById('detail-qty').innerText = qty;
        }
    }

    // Quantity selector
    let qty = 1;
    function changeDetailQty(delta) {
        const nextQty = qty + delta;
        if (nextQty >= 1 && nextQty <= selectedColorStock) {
            qty = nextQty;
            document.getElementById('detail-qty').innerText = qty;
        } else if (nextQty > selectedColorStock) {
            window.showToast(`Only ${selectedColorStock} units available for this color!`, 'error');
        }
    }

    function addDetailToCart() {
        let finalName = '{{ addslashes($product->name) }}';
        if (selectedColor && selectedColor !== 'Default') {
            finalName += ` (${selectedColor})`;
        }
        addToCart({{ $product->id }}, finalName, {{ $product->price }}, '{{ $product->img }}', qty);
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
        let finalName = '{{ addslashes($product->name) }}';
        if (selectedColor && selectedColor !== 'Default') {
            finalName += ` (${selectedColor})`;
        }
        addToCart({{ $product->id }}, finalName, {{ $product->price }}, '{{ $product->img }}', qty);
        location.href = '{{ route("checkout") }}';
    }

    // Review form star rating selection
    let selectedRating = 0;
    
    function setRating(rating) {
        selectedRating = rating;
        document.getElementById('review-rating-input').value = rating;
        updateStarColors(rating);
    }
    
    function highlightStars(rating) {
        updateStarColors(rating);
    }
    
    function resetStars() {
        updateStarColors(selectedRating);
    }
    
    function updateStarColors(rating) {
        document.querySelectorAll('.star-rating').forEach(star => {
            const val = parseInt(star.getAttribute('data-value'));
            if (val <= rating) {
                star.style.color = '#FFB800';
            } else {
                star.style.color = '#D1D5DB';
            }
        });
    }

    async function handleReviewSubmit(e) {
        e.preventDefault();
        const rating = document.getElementById('review-rating-input').value;
        if (!rating) {
            window.showToast('Please select a star rating.', 'error');
            return;
        }

        const formData = new FormData(e.target);
        try {
            const response = await fetch('/product/{{ $product->id }}/review', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (data.success) {
                window.showToast(data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                window.showToast(data.message || 'Failed to submit review.', 'error');
            }
        } catch (error) {
            window.showToast('An error occurred while submitting your review.', 'error');
        }
    }
</script>
@endsection
