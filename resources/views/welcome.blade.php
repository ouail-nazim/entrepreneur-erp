<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('landing.meta_title') }}</title>
    <meta name="description" content="{{ __('landing.meta_description') }}">
    <meta name="keywords" content="{{ __('landing.meta_keywords') }}">
    <meta property="og:title" content="{{ __('landing.meta_title') }}">
    <meta property="og:description" content="{{ __('landing.meta_description') }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--dark:#1a1a1a;--dark2:#2d2d2d;--dark3:#3a3a3a;--gold:#c9a84c;--gold-light:#d4b96a;--silver:#c0c0c0;--silver-light:#d9d9d9;--gray-bg:#f5f5f5;--text-light:#e0e0e0;--text-muted:#9a9a9a}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;color:var(--dark);overflow-x:hidden}
        h1,h2,h3,h4{font-family:'Playfair Display',serif}
        .mm-nav{position:fixed;top:0;width:100%;z-index:1000;padding:1.2rem 0;transition:all .4s}
        .mm-nav.scrolled{background:rgba(26,26,26,.97);backdrop-filter:blur(12px);padding:.7rem 0;box-shadow:0 2px 30px rgba(0,0,0,.4)}
        .mm-nav .nav-link{color:rgba(255,255,255,.8);font-weight:500;font-size:.85rem;letter-spacing:1px;text-transform:uppercase;padding:.5rem 1rem!important;transition:color .3s}
        .mm-nav .nav-link:hover,.mm-nav .nav-link.active{color:var(--gold)}
        .mm-nav .navbar-brand{color:#fff;font-family:'Playfair Display',serif;font-weight:700;font-size:1.2rem}
        .mm-nav .navbar-brand span{color:var(--gold)}
        .btn-gold{background:var(--gold);color:#fff;border:none;padding:.65rem 2rem;font-weight:600;font-size:.8rem;text-transform:uppercase;letter-spacing:1.5px;border-radius:0;transition:all .3s}
        .btn-gold:hover{background:var(--gold-light);color:#fff;transform:translateY(-2px)}
        .btn-outline-light-custom{border:1px solid rgba(255,255,255,.4);color:#fff;padding:.65rem 2rem;font-weight:600;font-size:.8rem;text-transform:uppercase;letter-spacing:1.5px;border-radius:0;transition:all .3s;background:transparent}
        .btn-outline-light-custom:hover{background:rgba(255,255,255,.1);color:var(--gold);border-color:var(--gold)}
        .hero{position:relative;height:100vh;min-height:700px;display:flex;align-items:center;background:var(--dark);overflow:hidden}
        .hero::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80') center/cover no-repeat;opacity:.3}
        .hero::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,26,26,.92) 0%,rgba(26,26,26,.6) 100%)}
        .hero .container{position:relative;z-index:2}
        .hero-badge{display:inline-block;color:var(--gold);font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:4px;margin-bottom:1.5rem;border:1px solid rgba(201,168,76,.3);padding:.6rem 1.8rem}
        .hero h1{font-size:3.8rem;font-weight:700;color:#fff;line-height:1.15;margin-bottom:1.5rem}
        .hero h1 span{color:var(--gold);display:block}
        .hero p{font-size:1.1rem;color:var(--silver);max-width:550px;line-height:1.9;margin-bottom:2.5rem}
        .section-pad{padding:100px 0}
        .section-hdr{text-align:center;margin-bottom:60px}
        .section-hdr h2{font-size:2.4rem;font-weight:700;margin-bottom:.8rem}
        .section-hdr p{color:var(--text-muted);font-size:1rem;max-width:600px;margin:0 auto}
        .gold-line{width:60px;height:3px;background:var(--gold);margin:1rem auto 0}
        .about-section{background:#fff}
        .about-img{width:100%;height:420px;object-fit:cover}
        .exp-badge{position:absolute;bottom:-25px;right:25px;background:var(--gold);color:#fff;padding:1.5rem 2rem;text-align:center}
        .exp-badge .num{font-size:2.5rem;font-weight:700;font-family:'Playfair Display',serif;display:block;line-height:1}
        .about-text p{color:#666;line-height:1.9;margin-bottom:1rem}
        .values-list{list-style:none;padding:0;display:flex;gap:1.5rem;flex-wrap:wrap;margin-top:1rem}
        .values-list li{display:flex;align-items:center;gap:.5rem;color:var(--dark);font-weight:500}
        .values-list li i{color:var(--gold);font-size:.9rem}
        .svc-card{background:#fff;padding:2.5rem 2rem;border:1px solid #eee;transition:all .4s;height:100%;position:relative;overflow:hidden}
        .svc-card::before{content:'';position:absolute;bottom:0;left:0;width:100%;height:3px;background:var(--gold);transform:scaleX(0);transition:transform .4s}
        .svc-card:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(0,0,0,.08)}
        .svc-card:hover::before{transform:scaleX(1)}
        .svc-card .svc-icon{width:60px;height:60px;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;color:var(--gold);font-size:1.4rem}
        .svc-card h4{font-size:1.15rem;font-weight:600;margin-bottom:.8rem}
        .svc-card p{color:#777;font-size:.92rem;line-height:1.7}
        .dark-section{background:var(--dark);color:#fff}
        .dark-section .section-hdr h2{color:#fff}
        .dark-section .section-hdr p{color:var(--silver)}
        .proj-item{position:relative;overflow:hidden;height:300px;cursor:pointer}
        .proj-item img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
        .proj-item:hover img{transform:scale(1.1)}
        .proj-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(26,26,26,.85) 0%,transparent 60%);display:flex;align-items:flex-end;padding:1.5rem;opacity:0;transition:opacity .4s}
        .proj-item:hover .proj-overlay{opacity:1}
        .proj-overlay h4{color:#fff;font-size:1.1rem;margin-bottom:.3rem}
        .proj-overlay span{color:var(--gold);font-size:.8rem;text-transform:uppercase;letter-spacing:1px}
        .team-card{text-align:center;padding:2rem 1.5rem}
        .team-icon{width:80px;height:80px;border-radius:50%;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;color:var(--gold);font-size:1.8rem;border:2px solid rgba(201,168,76,.2)}
        .team-card h4{font-size:1.05rem;font-weight:600;margin-bottom:.5rem}
        .team-card p{color:#777;font-size:.88rem;line-height:1.6}
        .why-card{display:flex;gap:1.2rem;margin-bottom:2rem}
        .why-num{width:50px;height:50px;min-width:50px;background:var(--gold);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:700}
        .why-card h4{font-size:1.05rem;font-weight:600;margin-bottom:.4rem}
        .why-card p{color:#777;font-size:.9rem;line-height:1.6;margin:0}
        .stats-section{background:var(--dark2);padding:80px 0}
        .stat-item{text-align:center;padding:2rem}
        .stat-item .stat-num{font-size:3rem;font-weight:700;color:var(--gold);font-family:'Playfair Display',serif;display:block}
        .stat-item .stat-label{color:var(--silver);font-size:.85rem;text-transform:uppercase;letter-spacing:2px;margin-top:.5rem}
        .testi-card{background:#fff;padding:2.5rem;border:1px solid #eee;height:100%}
        .testi-card .stars{color:var(--gold);margin-bottom:1rem}
        .testi-card p{color:#666;font-style:italic;line-height:1.8;margin-bottom:1.5rem;font-size:.95rem}
        .testi-author{display:flex;align-items:center;gap:1rem}
        .testi-avatar{width:50px;height:50px;border-radius:50%;background:var(--gold);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem}
        .testi-name{font-weight:600;font-size:.95rem}
        .testi-role{color:var(--text-muted);font-size:.8rem}
        .contact-section{background:var(--gray-bg)}
        .contact-info-card{background:var(--dark);color:#fff;padding:2.5rem;height:100%}
        .contact-info-card h3{color:var(--gold);font-size:1.3rem;margin-bottom:2rem}
        .contact-info-item{display:flex;gap:1rem;margin-bottom:1.5rem}
        .contact-info-item i{color:var(--gold);font-size:1.1rem;margin-top:.2rem}
        .contact-info-item span{color:var(--silver);font-size:.9rem;line-height:1.6}
        .contact-form{background:#fff;padding:2.5rem;height:100%;box-shadow:0 5px 20px rgba(0,0,0,.05)}
        .contact-form .form-control{border-radius:0;border:1px solid #ddd;padding:.8rem 1rem;font-size:.9rem}
        .contact-form .form-control:focus{border-color:var(--gold);box-shadow:0 0 0 .2rem rgba(201,168,76,.15)}
        .map-placeholder{background:var(--dark3);height:200px;display:flex;align-items:center;justify-content:center;color:var(--silver);margin-top:1.5rem}
        .cta-section{background:linear-gradient(135deg,var(--dark) 0%,var(--dark2) 100%);padding:80px 0;text-align:center}
        .cta-section h2{color:#fff;font-size:2.2rem;margin-bottom:1rem}
        .cta-section p{color:var(--silver);max-width:600px;margin:0 auto 2rem}
        .mm-footer{background:#111;color:var(--silver);padding:60px 0 30px}
        .mm-footer h5{color:#fff;font-size:1rem;font-weight:600;margin-bottom:1.5rem;text-transform:uppercase;letter-spacing:1px}
        .mm-footer a{color:var(--silver);text-decoration:none;transition:color .3s;font-size:.9rem}
        .mm-footer a:hover{color:var(--gold)}
        .mm-footer .footer-bottom{border-top:1px solid rgba(255,255,255,.1);margin-top:3rem;padding-top:1.5rem;text-align:center;color:var(--text-muted);font-size:.85rem}
        .fade-in{opacity:0;transform:translateY(30px);transition:all .8s ease}
        .fade-in.visible{opacity:1;transform:translateY(0)}
        @media(max-width:768px){
            .hero h1{font-size:2.4rem}
            .section-pad{padding:60px 0}
            .section-hdr h2{font-size:1.8rem}
            .stat-item .stat-num{font-size:2.2rem}
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg mm-nav">
        <div class="container">
            <a class="navbar-brand" href="#">{{ strtoupper($settings['app_name'] ?? 'Moustafa Marouf') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" style="border-color:rgba(255,255,255,.3)">
                <i class="fas fa-bars" style="color:#fff"></i>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#hero">{{ __('landing.nav_home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">{{ __('landing.nav_about') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">{{ __('landing.nav_services') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projects">{{ __('landing.nav_projects') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">{{ __('landing.nav_team') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">{{ __('landing.nav_contact') }}</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ url('lang/fr') }}" class="text-decoration-none px-2 py-1 {{ app()->getLocale() === 'fr' ? 'fw-bold' : '' }}" style="color:{{ app()->getLocale() === 'fr' ? 'var(--gold)' : '#fff' }};font-size:.9rem;">FR</a>
                    <span style="color:rgba(255,255,255,.4)">|</span>
                    <a href="{{ url('lang/en') }}" class="text-decoration-none px-2 py-1 {{ app()->getLocale() === 'en' ? 'fw-bold' : '' }}" style="color:{{ app()->getLocale() === 'en' ? 'var(--gold)' : '#fff' }};font-size:.9rem;">EN</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hero-badge">{{ __('landing.hero_badge') }}</div>
                    <h1>{{ __('landing.hero_title') }} <span>{{ __('landing.hero_title_highlight') }}</span></h1>
                    <p>{{ __('landing.hero_subtitle') }}</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#projects" class="btn-gold text-decoration-none">{{ __('landing.hero_cta_projects') }}</a>
                        <a href="#contact" class="btn-outline-light-custom text-decoration-none">{{ __('landing.hero_cta_contact') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="about-section section-pad" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 fade-in">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="{{ __('landing.about_title') }}" class="about-img" loading="lazy">
                        <div class="exp-badge">
                            <span class="num">15+</span>
                            <span>{{ __('landing.about_experience') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 fade-in about-text">
                    <h6 style="color:var(--gold);text-transform:uppercase;letter-spacing:3px;font-size:.75rem;margin-bottom:.8rem">{{ __('landing.about_title') }}</h6>
                    <h2 style="margin-bottom:1.5rem">{{ __('landing.about_subtitle') }}</h2>
                    <p>{{ __('landing.about_text_1') }}</p>
                    <p>{{ __('landing.about_text_2') }}</p>
                    <p>{{ __('landing.about_text_3') }}</p>
                    <h5 style="margin-top:1.5rem;font-size:1rem">{{ __('landing.about_values') }}</h5>
                    <ul class="values-list">
                        <li><i class="fas fa-check"></i> {{ __('landing.about_value_integrity') }}</li>
                        <li><i class="fas fa-check"></i> {{ __('landing.about_value_excellence') }}</li>
                        <li><i class="fas fa-check"></i> {{ __('landing.about_value_innovation') }}</li>
                        <li><i class="fas fa-check"></i> {{ __('landing.about_value_commitment') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="section-pad" id="services" style="background:var(--gray-bg)">
        <div class="container">
            <div class="section-hdr fade-in">
                <h2>{{ __('landing.services_title') }}</h2>
                <p>{{ __('landing.services_subtitle') }}</p>
                <div class="gold-line"></div>
            </div>
            <div class="row g-4">
                @php $svcs = [
                    ['icon'=>'fa-city','key'=>'promotion'],
                    ['icon'=>'fa-house-chimney','key'=>'villas'],
                    ['icon'=>'fa-building','key'=>'buildings'],
                    ['icon'=>'fa-helmet-safety','key'=>'civil'],
                    ['icon'=>'fa-hotel','key'=>'residences'],
                    ['icon'=>'fa-chart-line','key'=>'investment'],
                ]; @endphp
                @foreach($svcs as $s)
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="svc-card">
                        <div class="svc-icon"><i class="fas {{ $s['icon'] }}"></i></div>
                        <h4>{{ __('landing.service_'.$s['key']) }}</h4>
                        <p>{{ __('landing.service_'.$s['key'].'_desc') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects -->
    <section class="dark-section section-pad" id="projects">
        <div class="container">
            <div class="section-hdr fade-in">
                <h2>{{ __('landing.projects_title') }}</h2>
                <p>{{ __('landing.projects_subtitle') }}</p>
                <div class="gold-line"></div>
            </div>
            <div class="row g-3">
                @php $imgs = [
                    ['url'=>'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80','cat'=>'villas','t'=>'Villa Prestige'],
                    ['url'=>'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=600&q=80','cat'=>'buildings','t'=>'Résidence Émeraude'],
                    ['url'=>'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80','cat'=>'villas','t'=>'Villa Horizon'],
                    ['url'=>'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80','cat'=>'buildings','t'=>'Tour Diamant'],
                    ['url'=>'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&q=80','cat'=>'residences','t'=>'Résidence Palmiers'],
                    ['url'=>'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&q=80','cat'=>'villas','t'=>'Villa Royale'],
                ]; @endphp
                @foreach($imgs as $img)
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="proj-item">
                        <img src="{{ $img['url'] }}" alt="{{ $img['t'] }}" loading="lazy">
                        <div class="proj-overlay">
                            <div>
                                <h4>{{ $img['t'] }}</h4>
                                <span>{{ __('landing.project_category_'.$img['cat']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="section-pad" id="team">
        <div class="container">
            <div class="section-hdr fade-in">
                <h2>{{ __('landing.team_title') }}</h2>
                <p>{{ __('landing.team_subtitle') }}</p>
                <div class="gold-line"></div>
            </div>
            <div class="row g-4">
                @php $teams = [
                    ['icon'=>'fa-briefcase','key'=>'direction'],
                    ['icon'=>'fa-drafting-compass','key'=>'architects'],
                    ['icon'=>'fa-cogs','key'=>'engineers'],
                    ['icon'=>'fa-hard-hat','key'=>'supervisors'],
                    ['icon'=>'fa-wrench','key'=>'technicians'],
                    ['icon'=>'fa-users','key'=>'workers'],
                ]; @endphp
                @foreach($teams as $t)
                <div class="col-lg-4 col-md-6 fade-in">
                    <div class="team-card">
                        <div class="team-icon"><i class="fas {{ $t['icon'] }}"></i></div>
                        <h4>{{ __('landing.team_'.$t['key']) }}</h4>
                        <p>{{ __('landing.team_'.$t['key'].'_desc') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section-pad" style="background:var(--gray-bg)">
        <div class="container">
            <div class="section-hdr fade-in">
                <h2>{{ __('landing.why_title') }}</h2>
                <p>{{ __('landing.why_subtitle') }}</p>
                <div class="gold-line"></div>
            </div>
            <div class="row">
                @php $whys = ['expertise','quality','deadlines','support','innovation','satisfaction']; $i=1; @endphp
                @foreach($whys as $w)
                <div class="col-lg-6 fade-in">
                    <div class="why-card">
                        <div class="why-num">{{ str_pad($i++,2,'0',STR_PAD_LEFT) }}</div>
                        <div>
                            <h4>{{ __('landing.why_'.$w) }}</h4>
                            <p>{{ __('landing.why_'.$w.'_desc') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                @php $stats = [['num'=>150,'key'=>'projects'],['num'=>15,'key'=>'experience'],['num'=>200,'key'=>'clients'],['num'=>500,'key'=>'units']]; @endphp
                @foreach($stats as $st)
                <div class="col-lg-3 col-6 fade-in">
                    <div class="stat-item">
                        <span class="stat-num" data-target="{{ $st['num'] }}">0</span>
                        <div class="stat-label">{{ __('landing.stats_'.$st['key']) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section-pad">
        <div class="container">
            <div class="section-hdr fade-in">
                <h2>{{ __('landing.testimonials_title') }}</h2>
                <p>{{ __('landing.testimonials_subtitle') }}</p>
                <div class="gold-line"></div>
            </div>
            <div class="row g-4">
                @for($i=1;$i<=3;$i++)
                <div class="col-lg-4 fade-in">
                    <div class="testi-card">
                        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p>"{{ __('landing.testimonial_'.$i.'_text') }}"</p>
                        <div class="testi-author">
                            <div class="testi-avatar">{{ substr(__('landing.testimonial_'.$i.'_name'),0,1) }}</div>
                            <div>
                                <div class="testi-name">{{ __('landing.testimonial_'.$i.'_name') }}</div>
                                <div class="testi-role">{{ __('landing.testimonial_'.$i.'_role') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container fade-in">
            <h2>{{ __('landing.cta_title') }}</h2>
            <p>{{ __('landing.cta_subtitle') }}</p>
            <a href="#contact" class="btn-gold text-decoration-none d-inline-block">{{ __('landing.cta_button') }}</a>
            <div style="margin-top:1.5rem;color:var(--silver);font-size:.9rem">
                {{ __('landing.cta_phone') }}: <a href="tel:{{ $settings['company_phone'] ?? '' }}" style="color:var(--gold);text-decoration:none">{{ $settings['company_phone'] ?? '' }}</a>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="contact-section section-pad" id="contact">
        <div class="container">
            <div class="section-hdr fade-in">
                <h2>{{ __('landing.contact_title') }}</h2>
                <p>{{ __('landing.contact_subtitle') }}</p>
                <div class="gold-line"></div>
            </div>
            <div class="row g-4">
                <div class="col-lg-5 fade-in">
                    <div class="contact-info-card">
                        <h3>{{ __('landing.footer_contact') }}</h3>
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $settings['company_address'] ?? '' }}</span>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $settings['company_phone'] ?? '' }}</span>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $settings['company_email'] ?? '' }}</span>
                        </div>
                        <div class="map-placeholder">
                            <i class="fas fa-map fa-2x" style="margin-right:.8rem"></i> {{ __('landing.contact_map_placeholder') }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 fade-in">
                    <div class="contact-form">
                        <div class="row g-3">
                            <div class="col-md-6"><input type="text" class="form-control" placeholder="{{ __('landing.contact_form_name') }}"></div>
                            <div class="col-md-6"><input type="email" class="form-control" placeholder="{{ __('landing.contact_form_email') }}"></div>
                            <div class="col-md-6"><input type="tel" class="form-control" placeholder="{{ __('landing.contact_form_phone') }}"></div>
                            <div class="col-md-6"><input type="text" class="form-control" placeholder="{{ __('landing.contact_form_subject') }}"></div>
                            <div class="col-12"><textarea class="form-control" rows="5" placeholder="{{ __('landing.contact_form_message') }}"></textarea></div>
                            <div class="col-12"><button class="btn-gold w-100">{{ __('landing.contact_form_send') }}</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mm-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5>MOUSTAFA <span style="color:var(--gold)">MAROUF</span></h5>
                    <p style="font-size:.9rem;line-height:1.8">{{ __('landing.footer_about') }}</p>
                </div>
                <div class="col-lg-4">
                    <h5>{{ __('landing.footer_links') }}</h5>
                    <ul class="list-unstyled" style="line-height:2.2">
                        <li><a href="#about">{{ __('landing.nav_about') }}</a></li>
                        <li><a href="#services">{{ __('landing.nav_services') }}</a></li>
                        <li><a href="#projects">{{ __('landing.nav_projects') }}</a></li>
                        <li><a href="#team">{{ __('landing.nav_team') }}</a></li>
                        <li><a href="#contact">{{ __('landing.nav_contact') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>{{ __('landing.footer_contact') }}</h5>
                    <p style="font-size:.9rem;line-height:2"><i class="fas fa-map-marker-alt" style="color:var(--gold);width:20px"></i> {{ $settings['company_address'] ?? '' }}<br>
                    <i class="fas fa-phone" style="color:var(--gold);width:20px"></i> {{ $settings['company_phone'] ?? '' }}<br>
                    <i class="fas fa-envelope" style="color:var(--gold);width:20px"></i> {{ $settings['company_email'] ?? '' }}</p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} {{ $settings['company_name'] ?? '' }}. {{ __('landing.all_rights_reserved') }}
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll
        window.addEventListener('scroll',function(){document.querySelector('.mm-nav').classList.toggle('scrolled',window.scrollY>50)});
        // Fade in
        const obs=new IntersectionObserver(entries=>{entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target)}})},{threshold:.15});
        document.querySelectorAll('.fade-in').forEach(el=>obs.observe(el));
        // Counter
        document.querySelectorAll('.stat-num[data-target]').forEach(el=>{
            const obs2=new IntersectionObserver(entries=>{entries.forEach(e=>{if(e.isIntersecting){let t=+e.target.dataset.target,d=Math.max(1,Math.floor(2000/(t||1))),c=0;const timer=setInterval(()=>{c+=Math.ceil(t/60);if(c>=t){e.target.textContent=t+'+';clearInterval(timer)}else{e.target.textContent=c+'+'}},d);obs2.unobserve(e.target)}})},{threshold:.5});
            obs2.observe(el);
        });
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',function(e){e.preventDefault();const t=document.querySelector(this.getAttribute('href'));if(t)t.scrollIntoView({behavior:'smooth',block:'start'})})});
    </script>
</body>
</html>
