@extends('layouts.storefront')

@section('title', 'Secure Checkout - VELOX')

@section('content')
<div style="margin-top: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 2rem;">Secure Checkout</h1>

    <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 3.5rem;">
        <!-- Left: Accordion Checkout Sections -->
        <div>
            <!-- Shipping Information -->
            <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2rem; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <span style="background: var(--primary); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">1</span>
                    <h3 style="font-size: 1.25rem; font-weight: 700;">Shipping Information</h3>
                </div>
                
                <form id="shipping-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="grid-column: span 1;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">First Name</label>
                        <input type="text" placeholder="John" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 1;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Last Name</label>
                        <input type="text" placeholder="Doe" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Address Line 1</label>
                        <input type="text" placeholder="123 Luxury Lane" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 1;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">City</label>
                        <input type="text" placeholder="Beverly Hills" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 1;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">ZIP / Postal Code</label>
                        <input type="text" placeholder="90210" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                </form>
            </div>

            <!-- Delivery Options -->
            <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2rem; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <span style="background: var(--primary); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">2</span>
                    <h3 style="font-size: 1.25rem; font-weight: 700;">Delivery Method</h3>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <label style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: var(--transition);" class="delivery-label">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <input type="radio" name="delivery" checked style="accent-color: var(--primary);">
                            <div>
                                <div style="font-weight: 700; font-size: 0.95rem;">Standard Luxury Delivery</div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">Deliver in 2-3 business days</div>
                            </div>
                        </div>
                        <span style="font-weight: 700; color: #10B981;">FREE</span>
                    </label>

                    <label style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: var(--transition);" class="delivery-label">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <input type="radio" name="delivery" style="accent-color: var(--primary);">
                            <div>
                                <div style="font-weight: 700; font-size: 0.95rem;">Next-Day VIP Courier</div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">Guaranteed delivery tomorrow</div>
                            </div>
                        </div>
                        <span style="font-weight: 700;">+$25.00</span>
                    </label>
                </div>
            </div>

            <!-- Payment Options -->
            <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <span style="background: var(--primary); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">3</span>
                    <h3 style="font-size: 1.25rem; font-weight: 700;">Payment Method</h3>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Credit card fields mockup -->
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Cardholder Name</label>
                        <input type="text" placeholder="John Doe" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Card Number</label>
                            <input type="text" placeholder="•••• •••• •••• ••••" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Expiry</label>
                            <input type="text" placeholder="MM/YY" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">CVC</label>
                            <input type="text" placeholder="•••" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Sticky Order Summary & Coupon -->
        <div>
            <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color); position: sticky; top: 100px;">
                <h3 style="font-size: 1.25rem; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1.5rem;">Order Review</h3>

                <!-- Cart items summary -->
                <div id="checkout-items-list" style="max-height: 250px; overflow-y: auto; margin-bottom: 1.5rem;">
                    <!-- Rendered via JS -->
                </div>

                <!-- Subtotals -->
                <div style="display: flex; flex-direction: column; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--text-secondary);">
                        <span>Subtotal</span>
                        <span id="checkout-subtotal">₹0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--text-secondary);">
                        <span>Shipping</span>
                        <span id="checkout-shipping">Free</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--text-secondary);">
                        <span>Tax</span>
                        <span id="checkout-tax">₹0.00</span>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem;">
                    <span>Grand Total</span>
                    <span id="checkout-total">₹0.00</span>
                </div>

                <button class="btn btn-primary" onclick="placeOrderMock()" style="width: 100%; padding: 1.1rem;">Place Order Now</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function renderCheckoutSummary() {
        const listContainer = document.getElementById('checkout-items-list');
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            listContainer.innerHTML = `<p style="color:var(--text-secondary); text-align:center;">No items in cart.</p>`;
            return;
        }

        let subtotal = 0;
        listContainer.innerHTML = cart.map(item => {
            const itemSub = item.price * item.qty;
            subtotal += itemSub;
            return `
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                    <div style="display:flex; gap:0.75rem; align-items:center;">
                        <img src="${item.img}" style="width:40px; height:40px; border-radius:var(--radius-sm); object-fit:cover;">
                        <div>
                            <span style="font-weight:700; font-size:0.9rem;">${item.name}</span>
                            <div style="font-size:0.8rem; color:var(--text-secondary);">Qty: ${item.qty}</div>
                        </div>
                    </div>
                    <span style="font-weight:700; font-size:0.9rem;">₹${itemSub.toFixed(2)}</span>
                </div>
            `;
        }).join('');

        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        document.getElementById('checkout-subtotal').innerText = `₹${subtotal.toFixed(2)}`;
        document.getElementById('checkout-tax').innerText = `₹${tax.toFixed(2)}`;
        document.getElementById('checkout-total').innerText = `₹${total.toFixed(2)}`;
    }

    async function placeOrderMock() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        let subtotal = 0;
        cart.forEach(item => subtotal += item.price * item.qty);
        const total = subtotal * 1.08;

        const formData = new FormData();
        formData.append('total', total.toFixed(2));
        formData.append('_token', '{{ csrf_token() }}');
        
        cart.forEach((item, index) => {
            formData.append(`items[${index}][id]`, item.id);
            formData.append(`items[${index}][name]`, item.name);
            formData.append(`items[${index}][qty]`, item.qty);
            formData.append(`items[${index}][price]`, item.price);
        });

        @if(!auth()->check())
            alert('Please sign in to place your order.');
            location.href = '{{ route("auth") }}';
            return;
        @endif

        try {
            const response = await fetch('/checkout/order', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.success) {
                alert('Thank you! Your order was placed successfully. Tracking ID: ' + data.order_number);
                localStorage.removeItem('cart');
                
                // Clear cart badge
                const cartBadge = document.querySelector('.cart-badge');
                if(cartBadge) cartBadge.innerText = '0';
                
                location.href = "{{ route('track.order') }}?id=" + data.order_number;
            } else {
                alert(data.message || 'Error placing order.');
            }
        } catch (e) {
            alert('An error occurred while placing the order.');
        }
    }

    renderCheckoutSummary();
</script>
@endsection
