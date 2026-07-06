<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $settings['company_name'] ?? config('app.name', 'Entrepreneur ERP') }} - {{ __('landing.title') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .navbar {
            padding: 1rem 0;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .hero-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        .hero-title {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: #0d6efd;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .feature-card {
            padding: 2rem;
            border-radius: 1rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-weight: 700;
            margin-bottom: 3rem;
            text-align: center;
        }
        .footer {
            background: #212529;
            color: #fff;
            padding: 4rem 0 2rem;
        }
        .btn-primary {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .btn-outline-primary {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                @if(isset($settings['logo']) && $settings['logo'])
                    <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo" height="40" class="me-2">
                @endif
                {{ $settings['company_name'] ?? config('app.name', 'Entrepreneur ERP') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ url('/admin/dashboard') }}">{{ __('landing.get_started') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link fw-semibold me-3" href="{{ route('login') }}">{{ __('landing.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('register') }}">{{ __('landing.register') }}</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">{{ __('landing.hero_title') }}</h1>
                    <p class="hero-subtitle">{{ __('landing.hero_subtitle') }}</p>
                    <div class="d-flex gap-3">
                        @auth
                            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-lg">{{ __('landing.get_started') }}</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('landing.get_started') }}</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">{{ __('landing.login') }}</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://img.freepik.com/free-vector/dashboard-interface-user-panel-template-modern-flat-design-vector-illustration_56104-580.jpg" alt="ERP Dashboard" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 my-5">
        <div class="container">
            <h2 class="section-title">{{ __('landing.features_title') }}</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>{{ __('landing.feature_employees') }}</h3>
                        <p class="text-muted">{{ __('landing.feature_employees_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>{{ __('landing.feature_timesheets') }}</h3>
                        <p class="text-muted">{{ __('landing.feature_timesheets_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3>{{ __('landing.feature_inventory') }}</h3>
                        <p class="text-muted">{{ __('landing.feature_inventory_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>{{ __('landing.feature_purchases') }}</h3>
                        <p class="text-muted">{{ __('landing.feature_purchases_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h3>{{ __('landing.feature_invoicing') }}</h3>
                        <p class="text-muted">{{ __('landing.feature_invoicing_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>{{ __('landing.feature_reports') }}</h3>
                        <p class="text-muted">{{ __('landing.feature_reports_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="bg-light py-5">
        <div class="container py-5">
            <h2 class="section-title">{{ __('landing.why_choose_us') }}</h2>
            <div class="row g-5">
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary p-3 rounded-3 me-3 text-white">
                            <i class="fas fa-cubes fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold">{{ __('landing.reason_modular') }}</h4>
                            <p class="text-muted">{{ __('landing.reason_modular_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary p-3 rounded-3 me-3 text-white">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold">{{ __('landing.reason_secure') }}</h4>
                            <p class="text-muted">{{ __('landing.reason_secure_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary p-3 rounded-3 me-3 text-white">
                            <i class="fas fa-language fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold">{{ __('landing.reason_multilingual') }}</h4>
                            <p class="text-muted">{{ __('landing.reason_multilingual_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <div class="mb-4">
                <h3 class="fw-bold text-white">
                    {{ $settings['company_name'] ?? config('app.name', 'Entrepreneur ERP') }}
                </h3>
                <p class="text-secondary">{{ __('landing.footer_text') }}</p>
            </div>
            <div class="mb-4">
                <a href="#" class="text-secondary mx-3 text-decoration-none"><i class="fab fa-facebook fa-xl"></i></a>
                <a href="#" class="text-secondary mx-3 text-decoration-none"><i class="fab fa-twitter fa-xl"></i></a>
                <a href="#" class="text-secondary mx-3 text-decoration-none"><i class="fab fa-linkedin fa-xl"></i></a>
            </div>
            <hr class="bg-secondary">
            <p class="text-secondary mb-0">
                &copy; {{ date('Y') }} {{ $settings['company_name'] ?? config('app.name', 'Entrepreneur ERP') }}. {{ __('landing.all_rights_reserved') }}
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
