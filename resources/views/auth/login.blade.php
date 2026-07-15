<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings['app_name'] ?? 'Entrepreneur ERP' }} — {{ __('Login') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --dark: #1a1a1a;
            --dark-light: #2d2d2d;
            --gold: #c9a84c;
            --gold-hover: #b8963f;
            --silver: #c0c0c0;
            --light-bg: #f5f5f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--dark);
            overflow: hidden;
        }

        /* Left panel — branding */
        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(201,168,76,.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-brand .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 420px;
        }

        .login-brand .brand-logo {
            width: 90px;
            height: 90px;
            border: 2px solid var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .login-brand .brand-logo i {
            font-size: 2.2rem;
            color: var(--gold);
        }

        .login-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
            margin-bottom: .5rem;
        }

        .login-brand h1 span {
            color: var(--gold);
        }

        .login-brand .brand-tagline {
            color: var(--silver);
            font-size: .95rem;
            font-weight: 300;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .login-brand .brand-features {
            text-align: left;
            list-style: none;
            padding: 0;
        }

        .login-brand .brand-features li {
            color: rgba(255,255,255,.7);
            font-size: .85rem;
            padding: .6rem 0;
            border-bottom: 1px solid rgba(255,255,255,.06);
            display: flex;
            align-items: center;
            gap: .8rem;
        }

        .login-brand .brand-features li i {
            color: var(--gold);
            font-size: .75rem;
            width: 18px;
            text-align: center;
        }

        .brand-decoration {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: .5rem;
        }

        .brand-decoration span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            opacity: .4;
        }

        .brand-decoration span:nth-child(2) { opacity: .7; }
        .brand-decoration span:nth-child(3) { opacity: 1; }

        /* Right panel — form */
        .login-form-panel {
            flex: 1;
            background: var(--light-bg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .login-card .welcome-text {
            margin-bottom: 2.5rem;
        }

        .login-card .welcome-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: .5rem;
        }

        .login-card .welcome-text p {
            color: #888;
            font-size: .9rem;
            font-weight: 300;
        }

        .login-card .form-group {
            margin-bottom: 1.5rem;
        }

        .login-card label {
            display: block;
            font-size: .8rem;
            font-weight: 500;
            color: var(--dark-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: .5rem;
        }

        .login-card .input-wrapper {
            position: relative;
        }

        .login-card .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--silver);
            font-size: .9rem;
            transition: color .3s;
        }

        .login-card .form-control {
            width: 100%;
            padding: .85rem 1rem .85rem 2.8rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: .95rem;
            font-family: 'Inter', sans-serif;
            background: #fff;
            transition: border-color .3s, box-shadow .3s;
        }

        .login-card .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,.15);
        }

        .login-card .form-control:focus + i,
        .login-card .input-wrapper:focus-within i {
            color: var(--gold);
        }

        .login-card .form-control.is-invalid {
            border-color: #dc3545;
        }

        .login-card .invalid-feedback {
            font-size: .8rem;
            margin-top: .4rem;
        }

        .login-card .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .login-card .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }

        .login-card .form-check-label {
            font-size: .85rem;
            color: #666;
            text-transform: none;
            letter-spacing: 0;
        }

        .login-card .forgot-link {
            font-size: .85rem;
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: color .3s;
        }

        .login-card .forgot-link:hover {
            color: var(--gold-hover);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: .9rem;
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .95rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            letter-spacing: .5px;
            cursor: pointer;
            transition: background .3s, transform .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
        }

        .btn-login:hover {
            background: var(--dark-light);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            position: absolute;
            bottom: 2rem;
            text-align: center;
            font-size: .8rem;
            color: #aaa;
        }

        .login-footer a {
            color: var(--gold);
            text-decoration: none;
        }

        .lang-switch {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            gap: .3rem;
            align-items: center;
        }

        .lang-switch a {
            font-size: .8rem;
            text-decoration: none;
            padding: .3rem .6rem;
            border-radius: 4px;
            color: #888;
            transition: all .3s;
        }

        .lang-switch a.active {
            color: var(--dark);
            font-weight: 600;
            background: rgba(201,168,76,.15);
        }

        .lang-switch span {
            color: #ccc;
            font-size: .75rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .login-brand { display: none; }
            body { background: var(--light-bg); }
            .login-form-panel { padding: 2rem 1.5rem; }
        }

        @media (max-width: 576px) {
            .login-card .welcome-text h2 { font-size: 1.5rem; }
            .login-form-panel { padding: 1.5rem 1rem; }
        }
    </style>
</head>
<body>
    <!-- Left: Branding -->
    <div class="login-brand d-none d-lg-flex">
        <div class="brand-content">
            <div class="brand-logo">
                <i class="fas fa-building"></i>
            </div>
            <h1>{{ strtoupper($settings['app_name'] ?? 'Entrepreneur ERP') }}</h1>
            <p class="brand-tagline">{{ $settings['company_name'] ?? '' }}</p>
            <ul class="brand-features">
                <li><i class="fas fa-check"></i> {{ __('landing.service_1_title') }}</li>
                <li><i class="fas fa-check"></i> {{ __('landing.service_2_title') }}</li>
                <li><i class="fas fa-check"></i> {{ __('landing.service_3_title') }}</li>
                <li><i class="fas fa-check"></i> {{ __('landing.service_4_title') }}</li>
                <li><i class="fas fa-check"></i> {{ __('landing.service_5_title') }}</li>
            </ul>
        </div>
        <div class="brand-decoration">
            <span></span><span></span><span></span>
        </div>
    </div>

    <!-- Right: Login Form -->
    <div class="login-form-panel">
        <div class="lang-switch">
            <a href="{{ url('lang/fr') }}" class="{{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
            <span>|</span>
            <a href="{{ url('lang/en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>

        <div class="login-card">
            <div class="welcome-text">
                <h2>{{ __('Login') }}</h2>
                <p>{{ __('landing.hero_description') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <div class="input-wrapper">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                        <i class="fas fa-lock"></i>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    {{ __('Login') }}
                </button>
            </form>
        </div>

        <div class="login-footer">
            &copy; {{ date('Y') }} {{ $settings['company_name'] ?? '' }}. <a href="{{ url('/') }}">{{ __('landing.back_to_site') ?? __('landing.nav_home') }}</a>
        </div>
    </div>
</body>
</html>
