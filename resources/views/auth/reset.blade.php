@extends('layouts.storefront')

@section('title', 'Reset Password - Ocean Ecom')

@section('content')
<div style="max-width: 550px; margin: 4rem auto; min-height: 500px;">
    <!-- Tabs Header -->
    <div class="glass" style="border-radius: var(--radius-md) var(--radius-md) 0 0; border: 1px solid var(--border-color); display: flex;">
        <a href="{{ route('login') }}" class="auth-tab-btn" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; text-align: center; text-decoration: none; border-bottom: 3px solid transparent; color: var(--text-secondary);">Login</a>
        <a href="{{ route('register') }}" class="auth-tab-btn" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; text-align: center; text-decoration: none; border-bottom: 3px solid transparent; color: var(--text-secondary);">Register</a>
        <a href="{{ route('password.request') }}" class="auth-tab-btn" style="flex-grow: 1; padding: 1.25rem; font-weight: 700; text-align: center; text-decoration: none; border-bottom: 3px solid var(--primary); color: var(--text-primary);">Reset</a>
    </div>

    <!-- Tabs Body -->
    <div class="glass" style="border-radius: 0 0 var(--radius-md) var(--radius-md); border: 1px solid var(--border-color); border-top: none; padding: 3rem;">
        <!-- Forgot Password Form -->
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 0.5rem;">Recover Password</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">We will email you a VIP recovery link.</p>
            
            <form onsubmit="event.preventDefault(); window.showToast('Recovery email sent successfully.', 'success'); setTimeout(() => { location.href='{{ route('login') }}'; }, 1500);" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Email Address</label>
                    <input type="email" placeholder="you@luxury.com" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 0.9rem;">Send Recovery Email</button>
            </form>
        </div>
    </div>
</div>
@endsection
