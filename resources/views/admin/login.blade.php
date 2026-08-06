<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Authentication - Ocean Ecom</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23FF6B00%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><circle cx=%228%22 cy=%2221%22 r=%221%22></circle><circle cx=%2219%22 cy=%2221%22 r=%221%22></circle><path d=%22M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12%22></path></svg>">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(-45deg, #0A0A0B, #16161A, #2C1808, #0A0A0B);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: #F4F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Ambient glowing background blobs */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 107, 0, 0.1) 0%, rgba(0,0,0,0) 70%);
            top: 20%;
            left: 10%;
            z-index: 1;
            pointer-events: none;
            animation: floatGlow 10s ease-in-out infinite alternate;
        }

        .ambient-glow-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 107, 0, 0.08) 0%, rgba(0,0,0,0) 70%);
            bottom: 10%;
            right: 15%;
            z-index: 1;
            pointer-events: none;
            animation: floatGlow 8s ease-in-out infinite alternate-reverse;
        }

        @keyframes floatGlow {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-40px) scale(1.1); }
        }

        .login-card {
            width: 450px;
            padding: 3rem;
            border-radius: var(--radius-lg);
            background: rgba(22, 22, 26, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            box-sizing: border-box;
            text-align: center;
            position: relative;
            z-index: 2;
            overflow: hidden;
            animation: cardFadeIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Cyberpunk edge glow overlay */
        .login-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--radius-lg);
            padding: 1px;
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.4), transparent 40%, transparent 60%, rgba(255, 255, 255, 0.1));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .brand-logo {
            font-size: 2.25rem;
            font-weight: 900;
            letter-spacing: 4px;
            margin-bottom: 0.5rem;
            animation: logoSlide 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .brand-logo span {
            color: var(--primary);
        }

        @keyframes logoSlide {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .input-group {
            text-align: left;
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: formElementsFade 0.6s ease-out 0.4s forwards;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #9CA3AF;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-field {
            width: 100%;
            padding: 0.95rem 1.25rem;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(10, 10, 11, 0.6);
            color: #F4F4F6;
            font-size: 0.95rem;
            outline: none;
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .input-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(255, 107, 0, 0.25);
            background: rgba(10, 10, 11, 0.85);
            transform: scale(1.01);
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: white;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            margin-top: 1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(255, 107, 0, 0.25);
            opacity: 0;
            animation: formElementsFade 0.6s ease-out 0.6s forwards;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 0, 0.45);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.15);
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            text-align: left;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes formElementsFade {
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- Dynamic Background Elements -->
    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <div class="login-card">
        <div class="brand-logo">
            Ocean <span>Ecom</span>
        </div>
        
        <h2 style="font-size: 0.9rem; font-weight: 600; margin-bottom: 2rem; color: #9CA3AF; text-transform: uppercase; letter-spacing: 2px; opacity: 0; animation: formElementsFade 0.6s ease-out 0.2s forwards;">Store Administration</h2>

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="admin" value="{{ old('username') }}" class="input-field" autocomplete="off">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="admin" class="input-field">
            </div>

            <button type="submit" class="btn-submit">Log In</button>
            <button type="button" onclick="autofillAdmin()" style="width: 100%; padding: 0.85rem; border-radius: var(--radius-sm); background: rgba(255, 107, 0, 0.08); color: var(--primary); border: 1px dashed var(--primary); font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease; margin-top: 1rem; text-transform: uppercase; letter-spacing: 1px; box-sizing: border-box; opacity: 0; animation: formElementsFade 0.6s ease-out 0.6s forwards;">Autofill Credentials</button>
        </form>

        <a href="{{ route('home') }}" style="display: inline-block; margin-top: 2rem; color: #9CA3AF; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: var(--transition); opacity: 0; animation: formElementsFade 0.6s ease-out 0.8s forwards;" onmouseover="this.style.color='var(--primary)';" onmouseout="this.style.color='#9CA3AF';">
            ← Back to Storefront
        </a>
    </div>

    <!-- Core interactive Script & Toaster triggers -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function autofillAdmin() {
            document.getElementById('username').value = 'admin';
            document.getElementById('password').value = 'admin';
            if (window.showToast) {
                window.showToast("Admin credentials autofilled!", "success");
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if($errors->has('login_error'))
                window.showToast("{{ $errors->first('login_error') }}", 'error');
            @endif
            @if(session('success'))
                window.showToast("{{ session('success') }}", 'success');
            @endif
        });
    </script>
</body>
</html>
