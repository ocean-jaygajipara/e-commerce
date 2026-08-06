@extends('layouts.storefront')

@section('title', 'Register - Ocean Ecom')

@section('content')
<div style="max-width: 550px; margin: 4rem auto; min-height: 500px;">
    <!-- Tabs Header -->
    <div class="glass" style="border-radius: var(--radius-md) var(--radius-md) 0 0; border: 1px solid var(--border-color); display: flex;">
        <a href="{{ route('login') }}" class="auth-tab-btn" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; text-align: center; text-decoration: none; border-bottom: 3px solid transparent; color: var(--text-secondary);">Login</a>
        <a href="{{ route('register') }}" class="auth-tab-btn" style="flex-grow: 1; padding: 1.25rem; font-weight: 700; text-align: center; text-decoration: none; border-bottom: 3px solid var(--primary); color: var(--text-primary);">Register</a>
        <a href="{{ route('password.request') }}" class="auth-tab-btn" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; text-align: center; text-decoration: none; border-bottom: 3px solid transparent; color: var(--text-secondary);">Reset</a>
    </div>

    <!-- Tabs Body -->
    <div class="glass" style="border-radius: 0 0 var(--radius-md) var(--radius-md); border: 1px solid var(--border-color); border-top: none; padding: 3rem;">
        <!-- Register Form -->
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 0.5rem;">Create Account</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">Join the Ocean Ecom</p>
            
            <form id="register-form" onsubmit="handleRegister(event)" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Full Name</label>
                    <input type="text" name="name" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Email Address</label>
                    <input type="email" name="email" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Password</label>
                    <input type="password" name="password" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 0.9rem;">Register Account</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function handleRegister(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('/auth/register', {
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
                    location.href = '/';
                }, 1500);
            } else {
                window.showToast(data.message || 'Registration failed.', 'error');
            }
        } catch (error) {
            window.showToast('An error occurred or email is already registered.', 'error');
        }
    }
</script>
@endsection
