<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Authentication - VELOX</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background: #0A0A0B;
            color: #F4F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }

        .login-card {
            width: 450px;
            padding: 3rem;
            border-radius: var(--radius-lg);
            background: rgba(22, 22, 26, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-sizing: border-box;
            text-align: center;
        }

        .brand-logo {
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 4px;
            margin-bottom: 2rem;
        }

        .brand-logo span {
            color: var(--primary);
        }

        .input-group {
            text-align: left;
            margin-bottom: 1.5rem;
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
            padding: 0.9rem 1.25rem;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(10, 10, 11, 0.6);
            color: #F4F4F6;
            font-size: 0.95rem;
            outline: none;
            box-sizing: border-box;
            transition: var(--transition);
        }

        .input-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            border-radius: var(--radius-sm);
            background: var(--primary);
            color: white;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
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
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-logo">
            VELO<span>X</span>
        </div>
        
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #FFFFFF; text-transform: uppercase; letter-spacing: 1px;">Store Administration</h2>

        @if($errors->has('login_error'))
            <div class="error-message">
                ✕ {{ $errors->first('login_error') }}
            </div>
        @endif

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
        </form>

        <a href="{{ route('home') }}" style="display: inline-block; margin-top: 2rem; color: #9CA3AF; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: var(--transition);" onmouseover="this.style.color='var(--primary)';" onmouseout="this.style.color='#9CA3AF';">
            ← Back to Storefront
        </a>
    </div>

</body>
</html>
