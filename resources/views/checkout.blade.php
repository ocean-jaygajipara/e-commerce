@extends('layouts.storefront')

@section('title', 'Secure Checkout - Ocean Ecom')

@section('content')
<div style="margin-top: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 2rem;">Secure Checkout</h1>

    <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 3.5rem;">
        <!-- Left: Accordion Checkout Sections -->
        <div>
            <!-- Shipping Information -->
            <div class="glass" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 2rem; margin-bottom: 2rem; position: relative;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="background: var(--primary); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">1</span>
                        <h3 style="font-size: 1.25rem; font-weight: 700;">Delivery Address</h3>
                    </div>
                    <button type="button" id="btn-change-address" onclick="showAddressForm()" style="display: none; background: none; border: 1px solid var(--primary); color: var(--primary); padding: 0.4rem 1rem; border-radius: var(--radius-sm); font-weight: 700; cursor: pointer; font-size: 0.85rem; transition: var(--transition);" onmouseover="this.style.background='var(--primary)'; this.style.color='white';" onmouseout="this.style.background='none'; this.style.color='var(--primary)';">Change</button>
                </div>
                
                <!-- Saved Address Display Card -->
                <div id="saved-address-card" style="display: none; padding: 1rem 0; border-top: 1px dashed var(--border-color); margin-top: -0.5rem;">
                    <div style="font-weight: 700; font-size: 1.05rem; color: var(--text-primary); margin-bottom: 0.5rem;">
                        <span id="display-name">John Doe</span>
                        <span id="display-pincode" style="background: var(--light-grey); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-left: 0.5rem;">360001</span>
                    </div>
                    <p id="display-address-text" style="color: var(--text-secondary); font-size: 0.95rem; margin: 0; line-height: 1.5;"></p>
                </div>

                <!-- Editable Address Form -->
                <form id="shipping-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Full Name</label>
                        <input type="text" id="checkout-fullname" placeholder="John Doe" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Address Line 1</label>
                        <input type="text" id="checkout-address" placeholder="123 Luxury Lane" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 1;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">City</label>
                        <input type="text" id="checkout-city" placeholder="Beverly Hills" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                    </div>
                    <div style="grid-column: span 1;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">ZIP / Postal Code</label>
                        <input type="text" id="checkout-pincode" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);" placeholder="e.g. 360001" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                        <div id="checkout-pincode-result" style="margin-top: 0.5rem; font-size: 0.85rem; font-weight: 600; color: #10B981; display: none;"></div>
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

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- UPI -->
                    <label style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; cursor: pointer; transition: var(--transition);" class="payment-label">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <input type="radio" name="payment_method" value="upi" checked onclick="togglePaymentDetails('upi')" style="accent-color: var(--primary);">
                                <div>
                                    <div style="font-weight: 700; font-size: 0.95rem;">UPI (Google Pay / PhonePe / Paytm)</div>
                                    <div style="font-size: 0.85rem; color: var(--text-secondary);">Pay instantly using your UPI ID</div>
                                </div>
                            </div>
                        </div>
                        <div id="upi-details-block" style="display: flex; gap: 0.5rem; margin-left: 2.25rem; margin-top: 0.25rem;">
                            <input type="text" id="upi-id-input" placeholder="Enter UPI ID (e.g. user@okaxis)" style="flex-grow: 1; padding: 0.6rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary); outline: none; font-size: 0.9rem;">
                        </div>
                    </label>

                    <!-- QR Code -->
                    <label style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; cursor: pointer; transition: var(--transition);" class="payment-label">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <input type="radio" name="payment_method" value="qr" onclick="togglePaymentDetails('qr')" style="accent-color: var(--primary);">
                                <div>
                                    <div style="font-weight: 700; font-size: 0.95rem;">Scan QR Code</div>
                                    <div style="font-size: 0.85rem; color: var(--text-secondary);">Scan dynamic QR code to pay</div>
                                </div>
                            </div>
                        </div>
                        <div id="qr-details-block" style="display: none; flex-direction: column; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                            <div style="padding: 1rem; background: white; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=oceanecom@okaxis%26pn=OceanEcom%26mc=5732%26tid=123456%26tr=VLX-1234" alt="UPI QR Code" style="width: 150px; height: 150px;">
                            </div>
                            <span style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">Scan with GPay, PhonePe or BHIM App</span>
                        </div>
                    </label>

                    <!-- Cash on Delivery -->
                    <label style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: var(--transition);" class="payment-label">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <input type="radio" name="payment_method" value="cod" onclick="togglePaymentDetails('cod')" style="accent-color: var(--primary);">
                            <div>
                                <div style="font-weight: 700; font-size: 0.95rem;">Cash on Delivery (COD)</div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">Pay in cash when package is delivered</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right: Sticky Order Summary & Coupon -->
        <div style="position: sticky; top: 110px; height: fit-content; z-index: 10;">
            <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color);">
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

    document.getElementById('checkout-pincode').addEventListener('input', function(e) {
        const pincode = e.target.value.trim();
        const resultDiv = document.getElementById('checkout-pincode-result');
        
        if (pincode.length < 6 || isNaN(pincode)) {
            resultDiv.style.display = 'none';
            return;
        }

        // Fetch City from Postal PIN Code API
        fetch(`https://api.postalpincode.in/pincode/${pincode}`)
            .then(res => res.json())
            .then(data => {
                if (data && data[0] && data[0].Status === 'Success') {
                    const postOffice = data[0].PostOffice[0];
                    const city = postOffice.District || postOffice.Block;
                    if (city) {
                        document.getElementById('checkout-city').value = city;
                    }
                }
            })
            .catch(err => console.log('PIN code fetch failed', err));

        const days = parseInt(pincode[0]) % 3 + 2; // Mock delivery logic
        const date = new Date();
        date.setDate(date.getDate() + days);
        const options = { weekday: 'long', month: 'short', day: 'numeric' };
        const deliveryDateStr = date.toLocaleDateString('en-US', options);

        resultDiv.style.color = '#10B981';
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `🚚 Expected Delivery: <strong>${deliveryDateStr}</strong>`;
    });

    function showAddressForm() {
        document.getElementById('shipping-form').style.display = 'grid';
        document.getElementById('saved-address-card').style.display = 'none';
        document.getElementById('btn-change-address').style.display = 'none';
    }

    function autofillAddress() {
        const address = JSON.parse(localStorage.getItem('default_shipping_address'));
        if (address && address.fullname && address.line1 && address.city && address.pincode) {
            document.getElementById('checkout-fullname').value = address.fullname;
            document.getElementById('checkout-address').value = address.line1;
            document.getElementById('checkout-city').value = address.city;
            
            const pincodeInput = document.getElementById('checkout-pincode');
            pincodeInput.value = address.pincode;
            pincodeInput.dispatchEvent(new Event('input'));

            document.getElementById('display-name').innerText = address.fullname;
            document.getElementById('display-pincode').innerText = address.pincode;
            document.getElementById('display-address-text').innerText = `${address.line1}, ${address.city}`;

            document.getElementById('shipping-form').style.display = 'none';
            document.getElementById('saved-address-card').style.display = 'block';
            document.getElementById('btn-change-address').style.display = 'block';
        } else {
            showAddressForm();
        }
    }

    function togglePaymentDetails(method) {
        document.getElementById('upi-details-block').style.display = method === 'upi' ? 'flex' : 'none';
        document.getElementById('qr-details-block').style.display = method === 'qr' ? 'flex' : 'none';
    }

    renderCheckoutSummary();
    autofillAddress();
</script>
@endsection
