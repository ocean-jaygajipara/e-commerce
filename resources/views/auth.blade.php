@extends('layouts.storefront')

@section('title', 'Authentication - VELOX')

@section('content')
<div style="max-width: 550px; margin: 4rem auto; min-height: 500px;">
    <!-- Tabs Header -->
    <div class="glass" style="border-radius: var(--radius-md) var(--radius-md) 0 0; border: 1px solid var(--border-color); display: flex;">
        <button id="tab-btn-login" class="auth-tab-btn" onclick="showAuthTab('login')" style="flex-grow: 1; padding: 1.25rem; font-weight: 700; border: none; background: none; cursor: pointer; border-bottom: 3px solid var(--primary); color: var(--text-primary);">Login</button>
        <button id="tab-btn-register" class="auth-tab-btn" onclick="showAuthTab('register')" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; border: none; background: none; cursor: pointer; border-bottom: 3px solid transparent; color: var(--text-secondary);">Register</button>
        <button id="tab-btn-forgot" class="auth-tab-btn" onclick="showAuthTab('forgot')" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; border: none; background: none; cursor: pointer; border-bottom: 3px solid transparent; color: var(--text-secondary);">Reset</button>
    </div>

    <!-- Tabs Body -->
    <div class="glass" style="border-radius: 0 0 var(--radius-md) var(--radius-md); border: 1px solid var(--border-color); border-top: none; padding: 3rem;">
        
        <!-- Login Form -->
        <div id="auth-login" class="auth-content-pane">
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 0.5rem;">Welcome Back</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">Sign in to your luxury account.</p>
            
            <form id="login-form" onsubmit="handleLogin(event)" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Email Address</label>
                    <input type="email" name="email" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Password</label>
                    <input type="password" name="password" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 0.9rem;">Sign In</button>
            </form>
        </div>

        <!-- Register Form -->
        <div id="auth-register" class="auth-content-pane" style="display: none;">
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 0.5rem;">Create Account</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">Join the VELOX VIP membership.</p>
            
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

        <!-- Forgot Password Form -->
        <div id="auth-forgot" class="auth-content-pane" style="display: none;">
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 0.5rem;">Recover Password</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">We will email you a VIP recovery link.</p>
            
            <form onsubmit="event.preventDefault(); alert('Recovery email sent successfully.'); showAuthTab('login');" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Email Address</label>
                    <input type="email" placeholder="you@luxury.com" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 0.9rem;">Send Recovery Email</button>
            </form>
        </div>

        <!-- OTP Verification Pane -->
        <div id="auth-otp" class="auth-content-pane" style="display: none;">
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
    function showAuthTab(paneId) {
        document.querySelectorAll('.auth-content-pane').forEach(pane => pane.style.display = 'none');
        document.querySelectorAll('.auth-tab-btn').forEach(btn => {
            btn.style.color = 'var(--text-secondary)';
            btn.style.borderBottomColor = 'transparent';
        });

        const activePane = document.getElementById('auth-' + paneId);
        if(activePane) activePane.style.display = 'block';

        const activeBtn = document.getElementById('tab-btn-' + paneId);
        if(activeBtn) {
            activeBtn.style.color = 'var(--text-primary)';
            activeBtn.style.borderBottomColor = 'var(--primary)';
        }
    }

    async function handleLogin(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('/auth/login', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            
            if (data.success) {
                alert(data.message);
                location.href = '{{ route("dashboard") }}';
            } else {
                alert(data.message || 'Login failed.');
            }
        } catch (error) {
            alert('An error occurred. Check email & password.');
        }
    }

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
                alert(data.message);
                showAuthTab('otp');
            } else {
                alert(data.message || 'Registration failed.');
            }
        } catch (error) {
            alert('An error occurred or email is already registered.');
        }
    }

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
                alert(data.message);
                location.href = '{{ route("dashboard") }}';
            } else {
                alert(data.message || 'Verification failed.');
            }
        } catch (error) {
            alert('An error occurred during verification.');
        }
    }
</script>
@endsection
