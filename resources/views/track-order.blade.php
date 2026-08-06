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
            } else {
                alert(data.message || 'Consignment code not found.');
                container.style.display = 'none';
            }
        } catch (e) {
            alert('An error occurred while tracking the package.');
            container.style.display = 'none';
        }
    }

    // Auto trigger if ID parameter in URL exists
    const urlParams = new URLSearchParams(window.location.search);
    const trackingId = urlParams.get('id');
    if(trackingId) {
        document.getElementById('tracking-input').value = trackingId;
        showTrackingProgress();
    }
</script>
@endsection
