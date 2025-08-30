@extends('layouts.master2')

@section('title', trans('dashboard.logo'))

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #5b7db1;
            /* Soft Blue */
            --secondary-color: #a3c4f3;
            /* Light Blue */
            --accent-color: #f7d794;
            /* Muted Gold */
            --text-color-dark: #2b2b2b;
            --text-color-light: #f9f9f9;
            --bg-light: #f0f4f8;
            --bg-dark: #1e1e2f;
            --card-bg: #ffffff;
            --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.05);
            --shadow-strong: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-color-dark);
            direction: rtl;
            overflow-x: hidden;
            line-height: 1.8;
            scroll-behavior: smooth;
        }

        /* Nav Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
        }

        .navbar .logo {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--primary-color);
            text-decoration: none;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
        }

        .navbar .nav-links a {
            color: var(--text-color-dark);
            text-decoration: none;
            font-weight: 700;
            margin-left: 2rem;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: var(--primary-color);
        }

        .auth-buttons {
            display: flex;
            align-items: center;
        }

        .auth-buttons .btn {
            text-decoration: none;
            font-weight: 700;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .auth-buttons .btn-login {
            color: var(--primary-color);
            background: transparent;
            border: 2px solid var(--primary-color);
        }

        .auth-buttons .btn-register {
            background: var(--primary-color);
            color: #fff;
            margin-right: 1rem;
            border: 2px solid var(--primary-color);
        }

        .auth-buttons .btn-login:hover,
        .auth-buttons .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-strong);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--text-color-light);
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            position: relative;
            overflow: hidden;
        }

        .hero::before,
        .hero::after {
            content: '';
            position: absolute;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
            animation: move-bg 15s infinite alternate;
        }

        .hero::before {
            width: 700px;
            height: 700px;
            top: -20%;
            left: -20%;
        }

        .hero::after {
            width: 500px;
            height: 500px;
            bottom: -20%;
            right: -20%;
            animation-delay: -5s;
        }

        @keyframes move-bg {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(200px, 100px);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 2rem;
            animation: fade-slide-up 1.5s ease-out;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        /* Sections and Titles */
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 4rem;
            position: relative;
            color: var(--primary-color);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 5px;
            background: var(--accent-color);
            border-radius: 3px;
        }

        /* Services Section */
        .services-section {
            padding: 5rem 1rem;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 1.2rem;
            box-shadow: var(--shadow-light);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            position: relative;
            overflow: hidden;
            animation: fade-slide-up 1s ease forwards;
            opacity: 0;
        }

        .service-card i {
            font-size: 2.8rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .service-card:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-strong);
        }

        .service-card h3 {
            font-size: 1.3rem;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .service-card p {
            font-size: 1rem;
            color: #555;
        }

        /* About Section */
        .about-section {
            padding: 5rem 1rem;
            background-color: var(--bg-dark);
            color: var(--text-color-light);
        }

        .about-content {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            gap: 2rem;
        }

        .about-text {
            flex: 1;
        }

        .about-text p {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .about-image {
            flex: 1;
            max-width: 500px;
        }

        .about-image img {
            width: 100%;
            border-radius: 1rem;
            box-shadow: var(--shadow-strong);
            transform: rotateY(8deg) rotateX(4deg);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        .about-image img:hover {
            transform: rotateY(0deg) rotateX(0deg) scale(1.02);
            box-shadow: var(--shadow-strong);
        }

        /* Footer */
        .footer {
            padding: 2rem 1rem;
            background-color: #111;
            color: #ccc;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fade-slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .navbar .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 2rem;
                margin-bottom: 2rem;
            }

            .about-content {
                flex-direction: column;
            }

            .about-image img {
                transform: none;
            }
        }

        /* زر لوحة التحكم */
        .btn-dashboard {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 700;
            padding: 0.6rem 1.4rem;
            border: 2px solid var(--primary-color);
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .btn-dashboard:hover {
            background-color: #476a99;
            /* درجة أغمق من الأزرق */
            border-color: #476a99;
            transform: translateY(-3px);
            box-shadow: var(--shadow-strong);
        }

        /* زر تسجيل الخروج */
        .btn-logout {
            background-color: #d9534f;
            /* أحمر أنيق متناسق */
            color: #fff;
            font-weight: 700;
            padding: 0.6rem 1.4rem;
            border: 2px solid #d9534f;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 1rem;
            box-shadow: var(--shadow-light);
        }

        .btn-logout:hover {
            background-color: #c9302c;
            /* أحمر غامق */
            border-color: #c9302c;
            transform: translateY(-3px);
            box-shadow: var(--shadow-strong);
        }
    </style>
    <style>
        /* زر العودة للأعلى */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            display: none;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: var(--shadow-strong);
            transition: all 0.3s ease;
        }

        #backToTop:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* Fade + Slide Up عند الانتقال بين الأقسام */
        .section,
        .hero-content,
        .service-card,
        .about-content {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .section.visible,
        .hero-content.visible,
        .service-card.visible,
        .about-content.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>


@endsection

@section('body')
    <!-- Nav Bar -->
    <nav class="navbar">
        <a href="#" class="logo">{{ trans('dashboard.logo') }}</a>
        <div class="nav-links">
            <a href="#services">{{ trans('dashboard.services') }}</a>
            <a href="#about">{{ trans('dashboard.about') }}</a>
            <a href="#">{{ trans('dashboard.contact') }}</a>
        </div>
        <div class="auth-buttons">
            @guest
                <a href="{{ route('register.index') }}" class="btn btn-register">
                    {{ trans('dashboard.register') }}
                </a>
                <a href="{{ route('login.index') }}" class="btn btn-login">
                    {{ trans('dashboard.login') }}
                </a>
            @endguest
            @auth

                <!-- يظهر للمسجلين دخول -->
                @if (auth()->user()->type_user === 'admin')
                    <a href="{{ route('dashboard') }}" class="btn btn-dashboard">
                        {{ trans('dashboard.dashboard') }}
                    </a>
                @elseif(auth()->user()->type_user === 'service_provider')
                    <a href="{{ route('service_provider.dashboard') }}" class="btn btn-dashboard">
                        {{ trans('dashboard.dashboard') }}
                    </a>
                @elseif(auth()->user()->type_user === 'client')
                    <a href="{{ route('Client.dashboard') }}" class="btn btn-dashboard">
                        {{ trans('dashboard.dashboard') }}
                    </a>
                @endif

                <a href="{{ route('logout') }}" class="btn btn-logout" tyle="display:inline;">
                    {{ trans('dashboard.log_out') }}
                </a>

            @endauth

        </div>

    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-content">
            <h1>{{ trans('dashboard.hero_title') }}</h1>
            <p>{{ trans('dashboard.hero_text') }}</p>
        </div>
    </header>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <h2 class="section-title">{{ trans('dashboard.main_services') }}</h2>
            <div class="service-grid">
                <div class="service-card">
                    <i class="fas fa-handshake"></i>
                    <h3>{{ trans('dashboard.find_expert') }}</h3>
                    <p>{{ trans('dashboard.find_expert_text') }}</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-project-diagram"></i>
                    <h3>{{ trans('dashboard.easy_project_management') }}</h3>
                    <p>{{ trans('dashboard.easy_project_management_text') }}</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>{{ trans('dashboard.secure_transactions') }}</h3>
                    <p>{{ trans('dashboard.secure_transactions_text') }}</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-rocket"></i>
                    <h3>{{ trans('dashboard.speed_efficiency') }}</h3>
                    <p>{{ trans('dashboard.speed_efficiency_text') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container about-content">
            <div class="about-text">
                <h2 class="section-title">{{ trans('dashboard.about_us') }}</h2>
                <p>{{ trans('dashboard.about_us_text_1') }}</p>
                <p>{{ trans('dashboard.about_us_text_2') }}</p>
            </div>
            <div class="about-image">
                <img src="{{ URL::asset('assets/image/logo2.png') }}"
                    alt="Image of a team collaborating">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 {{ trans('dashboard.logo') }}. {{ trans('dashboard.copyright') }}</p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" title="{{ trans('dashboard.back_to_top') }}">
        <i class="fas fa-arrow-circle-up fa-2x"></i>
    </button>
    <script>
        // زر العودة للأعلى
        const backToTopBtn = document.getElementById("backToTop");

        window.onscroll = function() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                backToTopBtn.style.display = "block";
            } else {
                backToTopBtn.style.display = "none";
            }

            // Fade + Slide Up على الأقسام عند التمرير
            document.querySelectorAll('.section, .hero-content, .service-card, .about-content').forEach(el => {
                let rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('visible');
                }
            });
        };

        backToTopBtn.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endsection
