<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GroceryDeals – Find the freshest groceries, dairy, bakery, meat and more at unbeatable prices.">
    <title>@yield('title', 'GroceryDeals') | Fresh Deals Every Day</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Intro.js for site tour -->
    <link href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/introjs.min.css" rel="stylesheet">
    <style>
        /* ─── CSS Variables for Light / Dark ─── */
        [data-theme="light"] {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --primary-gradient: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
            --accent: #f59e0b;
            --bg: #f0fdf4;
            --bg2: #ffffff;
            --card-bg: #ffffff;
            --text: #1a1a2e;
            --text-muted: #6b7280;
            --border: #d1fae5;
            --border2: #e5e7eb;
            --sidebar-bg: #ffffff;
            --nav-bg: linear-gradient(135deg, #15803d 0%, #166534 100%);
            --feature-bg: #f0fdf4;
            --feature-border: #d1fae5;
            --footer-bg: #111827;
            --badge-cat-bg: #d1fae5;
            --badge-cat-text: #15803d;
            --shadow: 0 2px 15px rgba(0,0,0,0.06);
            --shadow-hover: 0 12px 35px rgba(0,0,0,0.12);
            --placeholder-bg: linear-gradient(135deg, #d1fae5, #a7f3d0);
            --input-bg: #ffffff;
            --input-border: #d1d5db;
            --input-text: #1a1a2e;
        }
        [data-theme="dark"] {
            --primary: #22c55e;
            --primary-dark: #16a34a;
            --primary-gradient: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            --accent: #fbbf24;
            --bg: #0f172a;
            --bg2: #1e293b;
            --card-bg: #1e293b;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #1e3a2f;
            --border2: #334155;
            --sidebar-bg: #1e293b;
            --nav-bg: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            --feature-bg: #1e293b;
            --feature-border: #334155;
            --footer-bg: #020617;
            --badge-cat-bg: #064e3b;
            --badge-cat-text: #34d399;
            --shadow: 0 2px 15px rgba(0,0,0,0.3);
            --shadow-hover: 0 12px 35px rgba(0,0,0,0.5);
            --placeholder-bg: linear-gradient(135deg, #064e3b, #065f46);
            --input-bg: #1e293b;
            --input-border: #334155;
            --input-text: #f1f5f9;
        }

        * { font-family: 'Outfit', sans-serif; box-sizing: border-box; }
        body { background: var(--bg); color: var(--text); transition: background 0.3s, color 0.3s; }

        /* ─── Navbar ─── */
        .navbar-custom {
            background: var(--nav-bg);
            box-shadow: 0 2px 20px rgba(21,128,61,0.3);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: background 0.3s;
        }
        .navbar-brand {
            font-size: 1.55rem; font-weight: 800;
            color: #fff !important; letter-spacing: -0.5px;
        }
        .navbar-brand span { color: var(--accent); }
        .nav-link { color: rgba(255,255,255,0.85) !important; font-weight: 500; transition: color 0.2s; }
        .nav-link:hover { color: #fff !important; }

        /* Dark Mode Toggle */
        .dark-toggle {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap: 6px;
        }
        .dark-toggle:hover { background: rgba(255,255,255,0.25); color: #fff; }

        /* Tour Button */
        .btn-tour {
            background: rgba(245,158,11,0.2);
            border: 1px solid rgba(245,158,11,0.5);
            color: #fcd34d;
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-tour:hover { background: rgba(245,158,11,0.35); color: #fbbf24; }

        .btn-cart {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff; border-radius: 50px;
            padding: 5px 16px; font-weight: 600; transition: all 0.2s;
        }
        .btn-cart:hover { background: rgba(255,255,255,0.25); color: #fff; }
        .btn-signup {
            background: var(--accent); color: #1a1a2e;
            border: none; border-radius: 50px;
            padding: 5px 18px; font-weight: 700; transition: all 0.2s;
        }
        .btn-signup:hover { background: #d97706; color: #fff; transform: translateY(-1px); }

        /* ─── Hero ─── */
        .hero-section {
            background: linear-gradient(135deg, #166534 0%, #15803d 40%, #16a34a 100%);
            color: white; padding: 5rem 0 4rem;
            position: relative; overflow: hidden;
        }
        [data-theme="dark"] .hero-section {
            background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #065f46 100%);
        }
        .hero-section::before {
            content: ''; position: absolute;
            top: -50%; right: -10%;
            width: 600px; height: 600px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .hero-badge {
            background: rgba(245,158,11,0.2);
            border: 1px solid rgba(245,158,11,0.5);
            color: #fcd34d; border-radius: 50px;
            padding: 4px 14px; font-size: 0.8rem;
            font-weight: 600; display: inline-block; margin-bottom: 1rem;
        }
        .hero-section h1 { font-size: 3.5rem; font-weight: 800; line-height: 1.1; }
        .hero-section h1 span { color: var(--accent); }
        .btn-hero-primary {
            background: #fff; color: var(--primary-dark);
            border: none; border-radius: 50px;
            padding: 14px 32px; font-weight: 700; font-size: 1.05rem;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); color: var(--primary-dark); }
        .btn-hero-outline {
            background: transparent; color: #fff;
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 50px; padding: 12px 28px;
            font-weight: 600; transition: all 0.3s;
        }
        .btn-hero-outline:hover { border-color: #fff; background: rgba(255,255,255,0.1); color: #fff; }
        .stats-pill {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px; padding: 8px 20px;
            font-size: 0.9rem; font-weight: 600;
        }

        /* ─── Section / Cards ─── */
        .section-title { font-size: 2rem; font-weight: 800; }
        .product-card {
            border: none; border-radius: 16px; overflow: hidden;
            transition: all 0.3s; box-shadow: var(--shadow);
            background: var(--card-bg); height: 100%;
        }
        .product-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-hover); }
        .product-card .card-img-top { height: 200px; object-fit: cover; }
        .product-img-placeholder {
            height: 200px;
            background: var(--placeholder-bg);
            display: flex; align-items: center; justify-content: center;
            font-size: 4rem;
        }
        .badge-deal {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white; font-size: 0.75rem; font-weight: 700;
            border-radius: 6px; padding: 4px 10px;
        }
        .badge-cat {
            background: var(--badge-cat-bg); color: var(--badge-cat-text);
            font-size: 0.72rem; font-weight: 600;
            border-radius: 50px; padding: 3px 10px;
        }
        .price-original { text-decoration: line-through; color: var(--text-muted); font-size: 0.9rem; }
        .price-deal { font-size: 1.5rem; font-weight: 800; color: var(--primary); }
        .btn-add-cart {
            background: var(--primary); color: white;
            border: none; border-radius: 50px;
            padding: 8px 20px; font-weight: 600;
            width: 100%; transition: all 0.2s;
        }
        .btn-add-cart:hover { background: var(--primary-dark); color: white; transform: translateY(-1px); }

        /* ─── Category Pills ─── */
        .cat-pill {
            border-radius: 50px; padding: 8px 20px;
            font-weight: 600; border: 2px solid var(--border2);
            color: var(--primary-dark); background: var(--card-bg);
            transition: all 0.2s; text-decoration: none; display: inline-block;
        }
        .cat-pill:hover, .cat-pill.active {
            background: var(--primary); border-color: var(--primary); color: white;
        }

        /* ─── Promo Banner ─── */
        .promo-banner {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 20px; color: white; padding: 2.5rem;
        }

        /* ─── Feature Cards ─── */
        .feature-card {
            background: var(--feature-bg);
            border: 1px solid var(--feature-border);
            border-radius: 16px; transition: all 0.3s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }

        /* ─── Sidebar Filter ─── */
        .filter-card {
            background: var(--sidebar-bg);
            border: 1px solid var(--border2);
            border-radius: 16px;
        }
        .filter-card .cat-link {
            color: var(--text-muted); text-decoration: none; transition: color 0.2s;
        }
        .filter-card .cat-link:hover, .filter-card .cat-link.active-cat { color: var(--primary); font-weight: 700; }

        /* ─── Footer ─── */
        footer { background: var(--footer-bg); color: #9ca3af; padding: 3rem 0 1.5rem; margin-top: 5rem; }
        footer .footer-brand { font-size: 1.5rem; font-weight: 800; color: white; }
        footer .footer-brand span { color: var(--accent); }
        footer a { color: #9ca3af; text-decoration: none; transition: color 0.2s; }
        footer a:hover { color: white; }
        footer input { background: var(--input-bg); color: var(--input-text); border-color: var(--input-border); }

        /* ─── Alerts ─── */
        .alert { border-radius: 12px; border: none; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        [data-theme="dark"] .alert-success { background: #064e3b; color: #6ee7b7; }
        [data-theme="dark"] .alert-danger { background: #450a0a; color: #fca5a5; }

        /* ─── General ─── */
        .rounded-xl { border-radius: 16px !important; }
        .section-pad { padding: 4rem 0; }
        .bg-section { background: var(--bg2); }

        /* Rating stars */
        .stars { color: #f59e0b; font-size: 0.8rem; }

        /* Intro.js custom theme */
        .introjs-tooltip { border-radius: 16px !important; font-family: 'Outfit', sans-serif !important; }
        .introjs-button { border-radius: 50px !important; font-family: 'Outfit', sans-serif !important; font-weight: 600 !important; }
        .introjs-nextbutton { background: var(--primary) !important; border-color: var(--primary-dark) !important; color: #fff !important; }
        .introjs-nextbutton:hover { background: var(--primary-dark) !important; }

        /* Scroll animations */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom" id="step-navbar" data-intro="Welcome to GroceryDeals! This is the main navigation bar where you can access all sections of the app." data-step="1">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">🛒 Grocery<span>Deals</span></a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" style="color:#fff;">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto ms-3">
                    <li class="nav-item" id="step-products" data-intro="Browse our full catalog of fresh groceries across all categories." data-step="2">
                        <a class="nav-link" href="{{ route('products.index') }}"><i class="bi bi-bag me-1"></i>Products</a>
                    </li>
                    <li class="nav-item" id="step-deals" data-intro="View today's hottest deals and limited-time offers." data-step="3">
                        <a class="nav-link" href="{{ route('deals.index') }}"><i class="bi bi-tag me-1"></i>Deals</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Tour Button -->
                    <button class="btn-tour" onclick="startTour()" id="step-tour" data-intro="Click here anytime to restart the guided tour." data-step="7">
                        <i class="bi bi-compass me-1"></i> Tour
                    </button>
                    <!-- Dark Mode Toggle -->
                    <button class="dark-toggle" onclick="toggleTheme()" id="step-darkmode" data-intro="Toggle between light and dark mode for comfortable browsing." data-step="6">
                        <i class="bi bi-moon-stars-fill" id="theme-icon"></i>
                        <span id="theme-label">Dark</span>
                    </button>
                    @auth
                        <a href="{{ route('cart.index') }}" class="btn btn-cart" id="step-cart" data-intro="Your shopping cart. Add products and checkout from here." data-step="5">
                            <i class="bi bi-cart3 me-1"></i> Cart
                        </a>
                        <span class="text-white-50 ms-1 d-none d-lg-inline">Hi, {{ Auth::user()->name }}!</span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm text-white-50 border-0 bg-transparent">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-signup" id="step-signup" data-intro="Create a free account to start adding items to your cart and enjoy exclusive deals!" data-step="4">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    @yield('hero')

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="footer-brand mb-2">🛒 Grocery<span>Deals</span></div>
                    <p class="small">Fresh deals on groceries every day. Save more, eat better.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-5"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="fs-5"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6 class="text-white mb-3">Shop</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="{{ route('products.index') }}">All Products</a></li>
                        <li class="mb-1"><a href="{{ route('deals.index') }}">Today's Deals</a></li>
                        <li class="mb-1"><a href="{{ route('products.index') }}?category=fruits">Fruits</a></li>
                        <li class="mb-1"><a href="{{ route('products.index') }}?category=vegetables">Vegetables</a></li>
                        <li class="mb-1"><a href="{{ route('products.index') }}?category=dairy">Dairy</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="text-white mb-3">Account</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="{{ route('login') }}">Login</a></li>
                        <li class="mb-1"><a href="{{ route('register') }}">Register</a></li>
                        @auth
                        <li class="mb-1"><a href="{{ route('cart.index') }}">My Cart</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3">Stay in the loop</h6>
                    <p class="small mb-3">Get weekly deals and fresh updates delivered to your inbox.</p>
                    <div class="input-group">
                        <input type="email" class="form-control rounded-start-pill border-0" placeholder="Your email address">
                        <button class="btn btn-warning rounded-end-pill fw-bold" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr style="border-color:#374151">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <p class="small mb-0">© {{ date('Y') }} GroceryDeals. All rights reserved.</p>
                <p class="small mb-0">Built with ❤️ using Laravel + MongoDB</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/intro.min.js"></script>

    <script>
        /* ─── Dark / Light Mode ─── */
        const html = document.documentElement;
        const themeIcon = document.getElementById('theme-icon');
        const themeLabel = document.getElementById('theme-label');

        function applyTheme(theme) {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('gd-theme', theme);
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-sun-fill';
                themeLabel.textContent = 'Light';
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill';
                themeLabel.textContent = 'Dark';
            }
        }

        function toggleTheme() {
            const current = html.getAttribute('data-theme');
            applyTheme(current === 'dark' ? 'light' : 'dark');
        }

        // Apply saved preference on load
        const savedTheme = localStorage.getItem('gd-theme') || 'light';
        applyTheme(savedTheme);

        /* ─── Intro.js Tour ─── */
        function startTour() {
            introJs().setOptions({
                steps: [
                    {
                        intro: '<strong>👋 Welcome to GroceryDeals!</strong><br>Let us show you around this app in a quick 30-second tour.',
                    },
                    {
                        element: document.querySelector('#step-navbar'),
                        intro: '🧭 <strong>Navigation Bar</strong><br>Access all sections — Products, Deals, Cart and your account from here.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#step-products'),
                        intro: '🛍️ <strong>Products</strong><br>Browse our full catalog: Fruits, Vegetables, Dairy, Bakery, Meat, Beverages and Snacks.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#step-deals'),
                        intro: '🔥 <strong>Deals</strong><br>Find daily flash sales and limited-time offers with massive discounts.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#step-signup') || document.querySelector('#step-cart'),
                        intro: '👤 <strong>Account</strong><br>Sign up for free to add items to your cart, track orders and get exclusive deals.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#step-darkmode'),
                        intro: '🌙 <strong>Dark Mode</strong><br>Toggle between light and dark themes for comfortable browsing day or night.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#step-tour'),
                        intro: '🎯 <strong>Tour Button</strong><br>Click this anytime to restart this guided tour.',
                        position: 'bottom'
                    },
                    {
                        intro: '✅ <strong>You\'re all set!</strong><br>Start shopping and enjoy the freshest deals. Happy grocery hunting! 🛒',
                    }
                ],
                showProgress: true,
                showBullets: true,
                exitOnOverlayClick: false,
                nextLabel: 'Next →',
                prevLabel: '← Back',
                doneLabel: 'Start Shopping!',
            }).start();
        }

        // Auto-start tour for first-time visitors
        if (!localStorage.getItem('gd-tour-done')) {
            setTimeout(startTour, 1200);
            localStorage.setItem('gd-tour-done', '1');
        }

        /* ─── Scroll Fade-in Animations ─── */
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>

    @yield('scripts')
</body>
</html>
