@extends('layouts.storefront')

@section('title', 'Track Order - VELOX')

@section('content')
<div style="max-width: 700px; margin: 3rem auto; min-height: 450px;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; text-align: center;">Order Tracking</h1>
    <p style="color: var(--text-secondary); text-align: center; margin-bottom: 3rem;">Enter your luxury consignment tracking number below to check shipment status.</p>

    <!-- Tracking Input Form -->
    <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color); margin-bottom: 3rem;">
        <form id="track-form" onsubmit="event.preventDefault(); showTrackingProgress();" style="display: flex; gap: 1rem;">
            <input id="tracking-input" type="text" placeholder="e.g. VLX-2026-10294" required style="flex-grow: 1; padding: 0.85rem 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary); outline: none; font-size: 1rem; font-weight: 600;">
            <button type="submit" class="btn btn-primary">Track Package</button>
        </form>
    </div>

    <!-- Stepper Tracker Container -->
    <div id="tracking-progress-container" class="glass" style="border-radius: var(--radius-md); padding: 3rem 2rem; border: 1px solid var(--border-color); display: none;">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <span style="font-size: 0.85rem; color: var(--primary); font-weight: 700;">CONSIGNMENT STATUS</span>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem; margin-bottom: 0.5rem;" id="consignment-title">In Transit</h3>
            <div id="expected-delivery-date" style="font-size: 1rem; font-weight: 700; color: #10B981;"></div>
        </div>

        <div id="tracking-steps-wrapper" style="display: flex; justify-content: space-between; position: relative; margin: 2rem 0;">
            <!-- Rendered dynamically via JS -->
        </div>
        <div id="tracking-details-summary" style="margin-top: 2.5rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
            <!-- Dynamic elements -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function showTrackingProgress() {
        const input = document.getElementById('tracking-input').value.trim();
        const container = document.getElementById('tracking-progress-container');
        const title = document.getElementById('consignment-title');

        try {
            const response = await fetch(`/api/track-order?order_number=${encodeURIComponent(input)}`);
            const data = await response.json();
            
            if (data.success) {
                title.innerText = 'Package Status: ' + data.status;
                container.style.display = 'block';

                // Configure tracking steps dynamically
                let steps = [
                    { name: 'Confirmed', key: 'Confirmed', icon: '1' },
                    { name: 'Packed', key: 'Packed', icon: '2' },
                    { name: 'Shipped', key: 'Shipped', icon: '🚚' },
                    { name: 'Delivered', key: 'Delivered', icon: '🏠' }
                ];

                const isReturnFlow = (data.status === 'Returned' || data.status === 'Refunded');
                if (isReturnFlow) {
                    steps.push({ name: 'Returned', key: 'Returned', icon: '↩' });
                    steps.push({ name: 'Refunded', key: 'Refunded', icon: '💰' });
                }

                // Determine active step index
                let activeIndex = 0;
                if (data.status === 'Packed') activeIndex = 1;
                else if (data.status === 'Shipped') activeIndex = 2;
                else if (data.status === 'Delivered') activeIndex = 3;
                else if (data.status === 'Returned') activeIndex = 4;
                else if (data.status === 'Refunded') activeIndex = 5;

                // Set progress line width based on active index
                let progressPercentage = 0;
                if (isReturnFlow) {
                    progressPercentage = (activeIndex / 5) * 80;
                } else {
                    progressPercentage = (activeIndex / 3) * 80;
                }

                // Mock estimated delivery date or details
                if (data.status === 'Refunded') {
                    document.getElementById('expected-delivery-date').innerHTML = `✓ Refund Processed Successfully!`;
                } else if (data.status === 'Returned') {
                    document.getElementById('expected-delivery-date').innerHTML = `↩ Package Returned. Refund is being processed.`;
                } else {
                    const estDate = new Date();
                    if (activeIndex < 3) {
                        estDate.setDate(estDate.getDate() + (3 - activeIndex));
                        const options = { weekday: 'long', month: 'short', day: 'numeric' };
                        document.getElementById('expected-delivery-date').innerHTML = `🚚 Expected Delivery: <span style="color:var(--text-primary);">${estDate.toLocaleDateString('en-US', options)}</span>`;
                    } else {
                        document.getElementById('expected-delivery-date').innerHTML = `✓ Package Delivered Successfully!`;
                    }
                }

                // Draw Steps HTML
                let stepsHtml = `
                    <div style="position: absolute; top: 14px; left: 10%; right: 10%; height: 4px; background: var(--border-color); z-index: 1;"></div>
                    <div style="position: absolute; top: 14px; left: 10%; width: ${progressPercentage}%; height: 4px; background: var(--primary); z-index: 2; transition: width 0.4s ease;"></div>
                `;

                steps.forEach((step, idx) => {
                    const isDone = idx <= activeIndex;
                    const iconContent = isDone ? '✓' : step.icon;
                    const bg = isDone ? 'var(--primary)' : 'var(--light-grey)';
                    const color = isDone ? 'white' : 'var(--text-secondary)';
                    const border = isDone ? 'none' : '1px solid var(--border-color)';
                    const fontW = isDone ? '700' : '500';
                    const textC = isDone ? 'var(--text-primary)' : 'var(--text-secondary)';

                    stepsHtml += `
                        <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: ${bg}; color: ${color}; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; border: ${border}; font-weight: 700;">
                                ${iconContent}
                            </div>
                            <span style="font-size: 0.85rem; font-weight: ${fontW}; margin-top: 0.5rem; color: ${textC};">${step.name}</span>
                        </div>
                    `;
                });

                document.getElementById('tracking-steps-wrapper').innerHTML = stepsHtml;

                // Render order details summary
                let itemsHtml = '';
                if (data.items && data.items.length > 0) {
                    data.items.forEach(prod => {
                        const img = prod.img || 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=150';
                        itemsHtml += `
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 50px; height: 50px; border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--border-color);">
                                        <img src="${img}" style="width:100%; height:100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary);">${prod.name}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-secondary);">Qty: ${prod.qty}</div>
                                    </div>
                                </div>
                                <span style="font-weight: 700; color: var(--text-primary); font-size: 0.9rem;">₹${parseFloat(prod.price).toFixed(2)}</span>
                            </div>
                        `;
                    });
                }

                // Get shipping address from database API response
                let addressText = '-';
                if (data.shipping_address && data.shipping_address.fullname && data.shipping_address.address) {
                    const sa = data.shipping_address;
                    addressText = `${sa.fullname}<br>${sa.address}, ${sa.city} - ${sa.pincode}`;
                }

                let returnButtonHtml = '';
                if (data.status === 'Delivered') {
                    returnButtonHtml = `
                        <button onclick="returnOrderFromTracker(${data.id})" class="btn" style="padding: 0.5rem 1rem; font-size: 0.85rem; background: #EF4444; color: white; border: none; border-radius: var(--radius-sm); cursor: pointer; font-weight: 700; width: fit-content;">Return Item</button>
                    `;
                }

                const summaryHtml = `
                    <h5 style="font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-top: 0; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px;">Items Ordered</h5>
                    <div style="display: flex; flex-direction: column; margin-bottom: 1.5rem;">
                        ${itemsHtml}
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; padding: 1.25rem 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); margin-bottom: 1.5rem;">
                        <div>
                            <h5 style="font-size: 0.85rem; font-weight: 700; color: var(--text-secondary); margin-top: 0; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px;">Shipping Address</h5>
                            <p style="font-size: 0.9rem; color: var(--text-primary); margin: 0; line-height: 1.5;">${addressText}</p>
                        </div>
                        <div>
                            <h5 style="font-size: 0.85rem; font-weight: 700; color: var(--text-secondary); margin-top: 0; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px;">Payment Details</h5>
                            <p style="font-size: 0.9rem; color: var(--text-primary); margin: 0; line-height: 1.5;">Method: Cash on Delivery (COD)<br>Total Amount: <strong>₹${parseFloat(data.total).toFixed(2)}</strong></p>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                        ${returnButtonHtml}
                    </div>
                `;

                document.getElementById('tracking-details-summary').innerHTML = summaryHtml;
            } else {
                window.showToast(data.message || 'Consignment code not found.', 'error');
                container.style.display = 'none';
            }
        } catch (e) {
            window.showToast('An error occurred while tracking the package.', 'error');
            container.style.display = 'none';
        }
    }

    function returnOrderFromTracker(orderId) {
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

    // Auto trigger if ID parameter in URL exists
    const urlParams = new URLSearchParams(window.location.search);
    const trackingId = urlParams.get('id');
    if(trackingId) {
        document.getElementById('tracking-input').value = trackingId;
        showTrackingProgress();
    }
</script>

<!-- Select2 Assets & custom styles for track-order -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
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
            minimumResultsForSearch: Infinity
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
