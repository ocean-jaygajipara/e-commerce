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
        <div style="text-align: center; margin-bottom: 2rem;">
            <span style="font-size: 0.85rem; color: var(--primary); font-weight: 700;">CONSIGNMENT STATUS</span>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-top: 0.25rem;" id="consignment-title">In Transit</h3>
        </div>

        <div style="display: flex; justify-content: space-between; position: relative; margin: 2rem 0;">
            <div style="position: absolute; top: 14px; left: 10%; right: 10%; height: 4px; background: var(--border-color); z-index: 1;"></div>
            <div id="tracking-progress-line" style="position: absolute; top: 14px; left: 10%; width: 0%; height: 4px; background: var(--primary); z-index: 2; transition: width 0.4s ease;"></div>

            <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">✓</div>
                <span style="font-size: 0.85rem; font-weight: 700; margin-top: 0.5rem; color: var(--text-primary);">Confirmed</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                <div id="step-2" style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-grey); color: var(--text-secondary); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; border: 1px solid var(--border-color);">2</div>
                <span style="font-size: 0.85rem; font-weight: 500; margin-top: 0.5rem; color: var(--text-secondary);">Packed</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                <div id="step-3" style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-grey); color: var(--text-secondary); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; border: 1px solid var(--border-color);">🚚</div>
                <span style="font-size: 0.85rem; font-weight: 500; margin-top: 0.5rem; color: var(--text-secondary);">Shipped</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; z-index: 5; background: var(--white); padding: 0 10px;">
                <div id="step-4" style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-grey); color: var(--text-secondary); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; border: 1px solid var(--border-color);">🏠</div>
                <span style="font-size: 0.85rem; font-weight: 500; margin-top: 0.5rem; color: var(--text-secondary);">Delivered</span>
            </div>
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
        const progressLine = document.getElementById('tracking-progress-line');
        const step2 = document.getElementById('step-2');
        const step3 = document.getElementById('step-3');
        const step4 = document.getElementById('step-4');

        try {
            const response = await fetch(`/api/track-order?order_number=${encodeURIComponent(input)}`);
            const data = await response.json();
            
            if (data.success) {
                title.innerText = 'Package Status: ' + data.status;
                container.style.display = 'block';

                let progress = 0;
                if(data.status === 'Packed') progress = 33;
                else if(data.status === 'Shipped') progress = 66;
                else if(data.status === 'Delivered') progress = 100;

                progressLine.style.width = (progress * 0.8) + '%';

                // Packed (step 2)
                if (progress >= 33) {
                    step2.style.background = 'var(--primary)';
                    step2.style.color = 'white';
                    step2.style.border = 'none';
                    step2.innerText = '✓';
                    step2.nextElementSibling.style.fontWeight = '700';
                    step2.nextElementSibling.style.color = 'var(--text-primary)';
                } else {
                    step2.style.background = 'var(--light-grey)';
                    step2.style.color = 'var(--text-secondary)';
                    step2.style.border = '1px solid var(--border-color)';
                    step2.innerText = '2';
                    step2.nextElementSibling.style.fontWeight = '500';
                    step2.nextElementSibling.style.color = 'var(--text-secondary)';
                }

                // Shipped (step 3)
                if (progress >= 66) {
                    step3.style.background = 'var(--primary)';
                    step3.style.color = 'white';
                    step3.style.border = 'none';
                    step3.innerText = '✓';
                    step3.nextElementSibling.style.fontWeight = '700';
                    step3.nextElementSibling.style.color = 'var(--text-primary)';
                } else {
                    step3.style.background = 'var(--light-grey)';
                    step3.style.color = 'var(--text-secondary)';
                    step3.style.border = '1px solid var(--border-color)';
                    step3.innerText = '🚚';
                    step3.nextElementSibling.style.fontWeight = '500';
                    step3.nextElementSibling.style.color = 'var(--text-secondary)';
                }

                // Delivered (step 4)
                if (progress >= 100) {
                    step4.style.background = 'var(--primary)';
                    step4.style.color = 'white';
                    step4.style.border = 'none';
                    step4.innerText = '✓';
                    step4.nextElementSibling.style.fontWeight = '700';
                    step4.nextElementSibling.style.color = 'var(--text-primary)';
                } else {
                    step4.style.background = 'var(--light-grey)';
                    step4.style.color = 'var(--text-secondary)';
                    step4.style.border = '1px solid var(--border-color)';
                    step4.innerText = '🏠';
                    step4.nextElementSibling.style.fontWeight = '500';
                    step4.nextElementSibling.style.color = 'var(--text-secondary)';
                }
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
