@extends('layouts.storefront')

@section('title', 'Shopping Cart - VELOX')

@section('content')
<div style="margin-top: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 2rem;">Your Cart</h1>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem;">
        <!-- Left: Cart Items List -->
        <div>
            <div id="cart-page-list">
                <!-- Loaded dynamically via js based on localStorage -->
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem;">
                <a href="{{ route('shop') }}" class="btn btn-outline">&larr; Continue Shopping</a>
                <button class="btn btn-outline" onclick="localStorage.removeItem('cart'); location.reload();" style="border-color: #EF4444; color: #EF4444;">Clear Shopping Bag</button>
            </div>
        </div>

        <!-- Right: Summary & Coupon -->
        <div>
            <!-- Shipping Estimation -->
            <div class="glass" style="border-radius: var(--radius-md); padding: 1.5rem; border: 1px solid var(--border-color); margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Estimate Shipping</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <select style="padding: 0.6rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary);">
                        <option>United States</option>
                        <option>United Kingdom</option>
                        <option>Canada</option>
                        <option>Germany</option>
                    </select>
                    <input type="text" placeholder="State / Province" style="padding: 0.6rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary);">
                    <input type="text" placeholder="Postal Code" style="padding: 0.6rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary);">
                    <button class="btn btn-outline" style="padding: 0.5rem;" onclick="alert('Estimated shipping updated!')">Calculate</button>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color);">
                <h3 style="font-size: 1.25rem; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1.5rem;">Order Summary</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--text-secondary);">
                        <span>Subtotal</span>
                        <span id="summary-subtotal">₹0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--text-secondary);">
                        <span>Shipping</span>
                        <span>Free Standard Shipping</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--text-secondary);">
                        <span>Tax estimate</span>
                        <span id="summary-tax">₹0.00</span>
                    </div>
                </div>

                <!-- Apply Coupon -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-secondary);">Promo Code</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input id="coupon-input" type="text" placeholder="Enter coupon (e.g. LUXURY20)" style="padding: 0.6rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary); flex-grow: 1; outline: none; font-size: 0.9rem;">
                        <button class="btn btn-primary" onclick="applyCoupon()" style="padding: 0.6rem 1rem; font-size: 0.9rem;">Apply</button>
                    </div>
                    <div id="coupon-success" style="font-size: 0.85rem; color: #10B981; font-weight: 600; margin-top: 0.5rem; display: none;">Discount code applied! (20% Off)</div>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem;">
                    <span>Order Total</span>
                    <span id="summary-total">₹0.00</span>
                </div>

                <a href="{{ route('checkout') }}" class="btn btn-primary" style="width: 100%; padding: 1.1rem;">Proceed To Checkout</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let discount = 0;

    window.renderCartPage = function() {
        const cartList = document.getElementById('cart-page-list');
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            cartList.innerHTML = `
                <div class="glass" style="border-radius: var(--radius-md); padding: 4rem; text-align: center; border: 1px solid var(--border-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1.5rem; opacity: 0.5; color: var(--primary);"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Your Cart is Empty</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">Explore our premium catalog to add luxury accents to your shopping bag.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            `;
            updateTotals(0);
            return;
        }

        let total = 0;
        cartList.innerHTML = cart.map(item => {
            const sub = item.price * item.qty;
            total += sub;
            return `
                <div class="glass" style="border-radius: var(--radius-md); padding: 1.5rem; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; gap: 2rem; margin-bottom: 1.5rem;">
                    <img src="${item.img}" style="width: 90px; height: 90px; border-radius: var(--radius-sm); object-fit: cover;">
                    <div style="flex-grow: 1;">
                        <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem;">${item.name}</h4>
                        <p style="color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Premium Luxury</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <button onclick="updateQty(${item.id}, -1)" style="border: 1px solid var(--border-color); background: none; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; border-radius: var(--radius-sm); color: var(--text-primary); font-weight: 600;">-</button>
                        <span style="font-size: 1rem; font-weight: 700; min-width: 20px; text-align: center;">${item.qty}</span>
                        <button onclick="updateQty(${item.id}, 1)" style="border: 1px solid var(--border-color); background: none; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; border-radius: var(--radius-sm); color: var(--text-primary); font-weight: 600;">+</button>
                    </div>
                    <div style="text-align: right; min-width: 120px;">
                        <span style="font-weight: 800; font-size: 1.2rem; color: var(--text-primary);">₹${sub.toFixed(2)}</span>
                        <div style="font-size: 0.85rem; color: var(--text-secondary);">₹${item.price.toFixed(2)} each</div>
                    </div>
                    <button onclick="removeFromCart(${item.id})" style="border: none; background: none; color: #EF4444; cursor: pointer; padding: 0.5rem; transition: var(--transition);" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </button>
                </div>
            `;
        }).join('');

        updateTotals(total);
    };

    function updateTotals(subtotal) {
        const tax = subtotal * 0.08;
        const total = (subtotal + tax) * (1 - discount);
        
        document.getElementById('summary-subtotal').innerText = `₹${subtotal.toFixed(2)}`;
        document.getElementById('summary-tax').innerText = `₹${tax.toFixed(2)}`;
        document.getElementById('summary-total').innerText = `₹${total.toFixed(2)}`;
    }

    window.applyCoupon = function() {
        const code = document.getElementById('coupon-input').value.trim().toUpperCase();
        if(code === 'LUXURY20') {
            discount = 0.20;
            document.getElementById('coupon-success').style.display = 'block';
            window.renderCartPage();
        } else {
            alert('Invalid coupon code!');
        }
    };

    window.renderCartPage();
</script>
@endsection
