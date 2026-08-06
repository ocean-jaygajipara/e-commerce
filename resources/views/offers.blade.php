@extends('layouts.storefront')

@section('title', 'Exclusive Offers - VELOX')

@section('content')
<div style="margin-top: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; text-align: center;">Seasonal Sales & Coupons</h1>
    <p style="color: var(--text-secondary); text-align: center; max-width: 600px; margin: 0 auto 3rem; line-height: 1.5;">Apply these premium vouchers during checkout to receive immediate reductions on your luxury order.</p>

    <!-- Coupons Row -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; margin-bottom: 4rem;">
        <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px dashed var(--primary); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="background: var(--primary); color: white; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700;">20% OFF</span>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-top: 0.5rem; margin-bottom: 0.25rem;">VIP Welcome discount</h3>
                <p style="color: var(--text-secondary); font-size: 0.85rem;">Applicable on all electronics and audio products.</p>
            </div>
            <button class="btn btn-secondary" onclick="copyCode('LUXURY20', this)" style="padding: 0.75rem 1.25rem;">LUXURY20</button>
        </div>

        <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px dashed var(--primary); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="background: var(--primary); color: white; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700;">10% OFF</span>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-top: 0.5rem; margin-bottom: 0.25rem;">Summer Couture Special</h3>
                <p style="color: var(--text-secondary); font-size: 0.85rem;">Applicable on leather outerwear and designer bags.</p>
            </div>
            <button class="btn btn-secondary" onclick="copyCode('SUMMER10', this)" style="padding: 0.75rem 1.25rem;">SUMMER10</button>
        </div>
    </div>

    <!-- Seasonal Sale Section -->
    <div style="border-radius: var(--radius-lg); overflow: hidden; background: #0A0A0B; color: white; display: flex; align-items: center; justify-content: space-between; padding: 4rem; position: relative;">
        <div>
            <h2 style="font-size: 2.5rem; font-weight: 850; margin-bottom: 1rem;">Mid-Season Clearance</h2>
            <p style="opacity: 0.8; max-width: 500px; margin-bottom: 2rem;">Save up to 50% on seasonal couture styles and lifestyle lighting. Discount applied automatically at checkout.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
        </div>
        <div style="font-size: 8rem; opacity: 0.15; font-weight: 800; transform: rotate(-10deg);">SALE</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyCode(code, btn) {
        navigator.clipboard.writeText(code);
        const originalText = btn.innerText;
        btn.innerText = 'Copied!';
        btn.style.background = '#10B981';
        setTimeout(() => {
            btn.innerText = originalText;
            btn.style.background = 'var(--dark-grey)';
        }, 1500);
    }
</script>
@endsection
