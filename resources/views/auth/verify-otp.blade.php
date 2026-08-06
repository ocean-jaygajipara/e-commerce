@extends('layouts.storefront')

@section('title', 'Verify OTP - Ocean Ecom')

@section('content')
<div style="max-width: 550px; margin: 4rem auto; min-height: 500px;">
    <!-- Tabs Header -->
    <div class="glass" style="border-radius: var(--radius-md) var(--radius-md) 0 0; border: 1px solid var(--border-color); display: flex;">
        <div class="auth-tab-btn" style="flex-grow: 1; padding: 1.25rem; font-weight: 700; text-align: center; border-bottom: 3px solid var(--primary); color: var(--text-primary);">OTP Verification</div>
    </div>

    <!-- Tabs Body -->
    <div class="glass" style="border-radius: 0 0 var(--radius-md) var(--radius-md); border: 1px solid var(--border-color); border-top: none; padding: 3rem;">
        <!-- OTP Verification Pane -->
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 0.5rem;">OTP Verification</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">Enter the 4-digit code sent to your email.</p>
            
            <form id="otp-form" onsubmit="handleVerifyOtp(event)" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <input type="text" maxlength="1" required class="otp-input-field" style="width:50px; height:50px; text-align:center; font-size:1.5rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;" oninput="this.nextElementSibling?.focus()">
                    <input type="text" maxlength="1" required class="otp-input-field" style="width:50px; height:50px; text-align:center; font-size:1.5rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;" oninput="this.nextElementSibling?.focus()">
                    <input type="text" maxlength="1" required class="otp-input-field" style="width:50px; height:50px; text-align:center; font-size:1.5rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;" oninput="this.nextElementSibling?.focus()">
                    <input type="text" maxlength="1" required class="otp-input-field" style="width:50px; height:50px; text-align:center; font-size:1.5rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 0.9rem;">Verify & Log In</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function handleVerifyOtp(e) {
        e.preventDefault();
        const digits = Array.from(document.querySelectorAll('.otp-input-field')).map(input => input.value).join('');
        
        const formData = new FormData();
        formData.append('otp', digits);
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const response = await fetch('/auth/verify-otp', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            
            if (data.success) {
                window.showToast(data.message, 'success');
                setTimeout(() => {
                    location.href = '{{ route("dashboard") }}';
                }, 1500);
            } else {
                window.showToast(data.message || 'Verification failed.', 'error');
            }
        } catch (error) {
            window.showToast('An error occurred during verification.', 'error');
        }
    }
</script>
@endsection
