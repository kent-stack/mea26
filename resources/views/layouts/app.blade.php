<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MEA 2026')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_mea.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css'])
    <style>
        body {
            isolation: isolate;
        }

        #tsparticles {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            background-color: #f8fbff;
        }

        #home > #tsparticles {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .bootcamp-timeline,
        #pengumuman {
            isolation: isolate;
            background-color: #f8fbff;
        }

        .content-wrapper main > #home ~ div,
        .content-wrapper footer {
            position: relative;
            z-index: 2;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        @media (min-width: 641px) {
            .content-wrapper {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .content-wrapper main {
                flex: 1 0 auto;
            }
        }

        body > *:not(#tsparticles):not(.content-wrapper) {
            position: relative;
            z-index: 1;
        }

        #tsparticles canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }

        /* Inline hero styles to ensure they're applied immediately */
    

.hero-content { 
    color: #07203a; max-width: 900px; 
}

.hero-content h1 { 
    font-size: clamp(32px, 6.5vw, 72px); 
    line-height: 1; 
    font-weight: 900; 
    color: #ffffff; 
    margin: 0 0 0.75rem 0; 
    text-transform: uppercase; 
    letter-spacing: -0.03em; 
    text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}
        
.hero-content .hero-sub { 
    display: block; 
    font-size: clamp(16px, 3.5vw, 40px); 
    font-weight: 700; 
    color: #ffffff; 
    margin: 0 0 1.25rem 0; 
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}
        
.hero-content p {
    font-size: clamp(14px, 2.3vw, 18px);
    font-weight: 400;
    color: #f0f4f8;
    max-width: 65ch;
    margin: 1.25rem 0 0 0;
    line-height: 1.6;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}

.hero-content .hero-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.9rem;
    margin-top: 1.25rem;
    width: 100%;
}

.hero-content .hero-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 170px;
    width: 170px;
    padding: 0.8rem 1.25rem;
    border-radius: 9999px;
    font-weight: 700;
    font-size: 0.98rem;
    text-decoration: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    box-shadow: 0 10px 22px -10px rgba(2, 6, 23, 0.6);
    text-align: center;
    background: #ffffff; /* desktop default: white */
    color: #0f172a;
    border: 1px solid rgba(15,23,42,0.06);
}

.hero-content .hero-btn:hover {
    opacity: 0.95;
    transform: translateY(-1px);
}

.hero-content .hero-btn-primary,
.hero-content .hero-btn-secondary {
    background: #ffffff;
    color: #0f172a;
    border: 1px solid rgba(15,23,42,0.06);
}

.hero-content .hero-btn-secondary {
    background: #ffffff;
}
        /* sponsor styles moved to resources/css/app.css */
        /* Fallback: ensure sponsor styles apply when Vite dev server is not running */
.support-inner { 
    display: flex !important; 
    gap: clamp(1rem, 3vw, 3rem); 
    align-items: center; 
    justify-content: center;
    overflow-x: auto; 
    -webkit-overflow-scrolling: touch; }
.sponsor-item { 
    flex: 0 0 auto;
    display: flex; 
    align-items: center;
    justify-content: center; 
    padding: 0.25rem 0.5rem; }
.sponsor-logo { 
    height: clamp(40px, 12vw, 64px); 
    max-width: 220px; 
    width: auto; 
    display: block; 
    object-fit: contain; 
    margin-bottom: clamp(20px, 5vw, 50px);
}
.support-header { 
    text-align: center; 
    color: #374151; 
    font-weight: 700; 
    font-size: clamp(1rem, 3vw, 1.5rem);
    margin-bottom: clamp(1.75rem, 5vw, 2.25rem); 
    margin-top: clamp(2rem, 5vw, 3rem);
}
        /* Fallback to hide Alpine-controlled elements until JS loads */
        [x-cloak] { display: none !important; }

        /* Mobile hero layout: center content and style action buttons like the reference */
        @media (max-width: 640px) {
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                overflow-x: hidden !important;
                background-color: #ffffff !important;
            }

            .content-wrapper {
                display: flex !important;
                flex-direction: column !important;
                min-height: 100vh !important;
            }

            .content-wrapper main {
                flex: 1 0 auto !important;
            }

            footer {
                margin-top: auto !important;
                position: relative !important;
            }

            main {
                padding-top: 0 !important;
            }

            #home {
                width: 100vw !important;
                margin-left: calc(50% - 50vw) !important;
                background-image: url("{{ asset('images/bg_new.svg') }}") !important;
                background-position: top center !important;
                background-size: cover !important;
                background-repeat: no-repeat !important;
                background-color: #dfeaf2 !important;
                min-height: 100vh !important;
                display: flex !important;
                align-items: center !important; /* center vertically */
                justify-content: center !important; /* center horizontally */
                padding: 0 !important;
            }

            /* nudge content slightly lower so it sits like reference */
            .hero-content,
            .hero-small {
                width: 100% !important;
                max-width: 100% !important;
                text-align: center !important;
                padding: 0 1.25rem !important;
                margin: 0vh 0 0 0 !important; /* push down further from top to match reference */
            }

            .hero-content h1 {
                font-size: clamp(2.2rem, 11vw, 3.2rem) !important;
                line-height: 1.02 !important;
                letter-spacing: -0.05em !important;
                margin: 0 0 0.8rem 0 !important; /* h1 -> subtitle */
                text-transform: uppercase !important;
                font-weight: 900 !important;
                max-width: 34ch !important; /* force wrapping into multiple stacked lines like reference */
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .hero-content .hero-sub {
                font-size: clamp(1.2rem, 5vw, 1.6rem) !important;
                line-height: 1.1 !important;
                display: block !important;
                margin: 0 0 0.9rem 0 !important; /* subtitle -> paragraph */
                font-weight: 700 !important;
                letter-spacing: 0.06em !important;
                text-transform: uppercase !important;
            }

            .hero-content p {
                max-width: 100% !important;
                font-size: 1.15rem !important;
                line-height: 1.4 !important;
                margin: 0.9rem 0 0.8rem 0 !important;
                color: rgba(255,255,255,0.95) !important;
                font-weight: 700 !important;
                letter-spacing: 0 !important;
                text-transform: none !important;
            }

            /* action buttons styling to match reference */
            .hero-content .hero-actions {
                display: flex !important;
                gap: 0.9rem !important; /* button spacing */
                margin-top: 1.1rem !important; /* subtitle -> buttons */
                flex-wrap: nowrap !important;
                justify-content: center !important;
                align-items: center !important;
                width: 100% !important;
                padding: 0 1rem !important;
                box-sizing: border-box !important;
            }
            .hero-content .hero-btn {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.7rem 1.2rem !important;
                border-radius: 9999px !important;
                font-weight: 800 !important;
                text-decoration: none !important;
                flex: 1 1 0 !important;
                min-width: 0 !important;
                width: 100% !important;
                max-width: 180px !important;
                box-shadow: 0 10px 22px -10px rgba(2,6,23,0.6) !important;
                font-size: 0.96rem !important;
                text-align: center !important;
                background: #3b82f6 !important;
                color: #ffffff !important;
                border: 1px solid rgba(255,255,255,0.25) !important;
            }

            .hero-content .hero-btn-primary,
            .hero-content .hero-btn-secondary {
                background: #3b82f6 !important;
                color: #ffffff !important;
            }

            .support,
            .support-inner {
                background: transparent !important;
            }

            footer .footer-nav-list,
            footer .footer-contact-list {
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 0.5rem 0.8rem !important;
                list-style: none !important;
                margin: 0 auto !important;
                padding: 0 !important;
                width: fit-content !important;
                text-align: center !important;
            }

            footer .footer-nav-list {
                flex-wrap: nowrap !important;
            }

            footer .footer-contact-list {
                flex-wrap: nowrap !important;
            }

            footer .footer-nav-list li,
            footer .footer-contact-list li {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin: 0 !important;
                line-height: 1.2 !important;
                white-space: nowrap !important;
            }
        }
        @media (min-width: 641px) {
            .navbar-hero .nav-pill {
                background: rgba(255,255,255,0.95) !important;
                box-shadow: 0 10px 22px -10px rgba(2, 6, 23, 0.35) !important;
                border-radius: 9999px !important;
            }

            .navbar-hero .nav-pill > a,
            .navbar-hero .nav-pill > div > button {
                color: #0f172a !important;
            }

            .navbar-hero .nav-pill > a:hover,
            .navbar-hero .nav-pill > div > button:hover {
                color: #0f172a !important;
            }

            .hero-content h1,
            .hero-content .hero-sub,
            .hero-content p {
                color: #08203a !important;
                text-shadow: none !important;
            }

            .hero-content .hero-btn,
            .hero-content .hero-btn-primary,
            .hero-content .hero-btn-secondary {
                background: #3b82f6 !important;
                color: #ffffff !important;
            }
        }

        /* Desktop-specific hero: left-aligned content with background image on right */
        /* Global reset so navbar sits flush at top on all viewports */
        html, body { margin: 0; padding: 0; }

        @media (min-width: 768px) {
            /* Let the home hero start at the very top behind the navbar. */
            .hero-active main {
                padding-top: 0 !important;
            }

            /* Keep the new background image visible on desktop without removing the hero content */
            #home {
                background-image: url("{{ asset('images/bg_new.svg') }}") !important;
                background-color: #dfeaf2 !important;
                background-position: top center !important;
                background-size: cover !important;
                background-repeat: no-repeat !important;
            }

            .hero-content,
            .hero-small {
                max-width: 580px !important;
                text-align: left !important;
                margin-left: 0 !important;
                padding-left: 2rem !important;
                padding-right: 2rem !important;
            }
            /* Desktop: slightly smaller, tighter heading and spacing to match reference */
            .hero-content h1 {
                font-size: clamp(28px, 3.6vw, 48px) !important;
                line-height: 1.02 !important;
                font-weight: 800 !important;
                text-align: left !important;
                margin: 0 0 0.5rem 0 !important;
                letter-spacing: -0.03em !important;
                text-transform: uppercase !important;
            }
            .hero-content .hero-sub {
                font-size: clamp(18px, 2.6vw, 28px) !important;
                font-weight: 700 !important;
                margin: 0 0 0.5rem 0 !important;
                line-height: 1.1 !important;
                text-transform: none !important;
            }
            .hero-content p {
                font-size: 16px !important;
                font-weight: 700 !important;
                color: #0f172a !important;
                margin: 0.6rem 0 0 0 !important;
                line-height: 1.6 !important;
                max-width: 60ch !important;
            }
            .hero-content .hero-actions {
                justify-content: flex-start !important;
                gap: 1rem !important;
                margin-top: 0.9rem !important;
            }
            .hero-content .hero-btn {
                width: auto !important;
                min-width: 150px !important;
                max-width: none !important;
                padding: 0.6rem 1.1rem !important;
                font-size: 0.95rem !important;
            }

            /* Desktop: set hero text to dark and buttons to blue */
            .hero-content h1,
            .hero-content .hero-sub,
            .hero-content p {
                color: #0f172a !important; /* dark text */
                text-shadow: none !important;
            }

            .hero-content .hero-btn {
                background: #3b82f6 !important; /* blue */
                color: #ffffff !important;
                border: 1px solid rgba(59,130,246,0.12) !important;
            }

            .hero-content .hero-btn-primary,
            .hero-content .hero-btn-secondary {
                background: #3b82f6 !important;
                color: #ffffff !important;
            }

            /* Navbar defaults and hero-integration rules */
            .navbar-hero { position: sticky; top: 0; }
            .navbar-hero .nav-pill {
                background: rgba(255,255,255,0.98);
                box-shadow: 0 10px 22px -10px rgba(2,6,23,0.6);
                border-radius: 9999px;
            }

            /* When body has hero-active (home page), make the navbar pill sit inside the hero */
            .hero-active .navbar-hero {
                position: fixed !important;
                top: 1.25rem !important; /* slightly below top like screenshot */
                left: 50%;
                transform: translateX(-50%);
                width: auto;
                pointer-events: auto;
            }
            .hero-active .navbar-hero .nav-pill {
                background: rgba(255,255,255,0.98);
                box-shadow: 0 10px 22px -10px rgba(2,6,23,0.6); /* restore pill shadow */
                border-radius: 9999px;
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }
        }

        .navbar-hero .nav-pill {
            background: #ffffff !important;
        }

        .navbar-hero .nav-pill-link,
        .navbar-hero .nav-pill-user,
        .navbar-hero .nav-pill-user-btn,
        .navbar-hero .nav-pill-login {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
            min-height: 2.25rem !important;
            min-width: 3.25rem !important;
            line-height: 1 !important;
        }

        .navbar-hero .nav-pill-login {
            min-width: 4.5rem !important;
        }

        .navbar-hero .nav-pill-user-btn {
            width: 2.25rem !important;
            height: 2.25rem !important;
            padding: 0.25rem !important;
            color: #111827 !important;
        }

        .navbar-hero .nav-pill > a,
        .navbar-hero .nav-pill > div > button {
            color: #111827 !important;
        }

        .navbar-hero .nav-pill > a:hover,
        .navbar-hero .nav-pill > div > button:hover {
            color: #111827 !important;
        }

        body:not(.hero-active) main {
            padding-top: 0 !important;
        }

        @media (min-width: 768px) {
            body:not(.hero-active) .navbar-hero {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 50 !important;
            }
        }

        @media (min-width: 641px) {
            body:not(.hero-active) main {
                padding-top: 1.5rem !important;
            }

            .navbar-hero {
                width: 100% !important;
                margin-top: 0 !important;
            }

            .hero-active .navbar-hero {
                top: 0 !important;
                left: 0 !important;
                transform: none !important;
            }

            .navbar-hero > div {
                max-width: none !important;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

            .navbar-hero > div > div {
                width: 100% !important;
            }

            .navbar-hero .nav-desktop-bar {
                position: relative;
                min-height: 4rem;
                border-radius: 0 !important;
                padding: 0 2rem !important;
                background: rgba(255, 255, 255, 0.84) !important;
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12) !important;
            }

            .navbar-hero.is-scrolled .nav-desktop-bar {
                background: #ffffff !important;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }

            .navbar-hero .nav-desktop-brand img {
                display: block;
                height: 2.25rem;
                width: auto;
                min-width: 0;
            }

            .navbar-hero .nav-desktop-links {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                gap: 1.5rem !important;
            }

            .navbar-hero .nav-desktop-links .nav-pill-link {
                min-width: auto !important;
                min-height: 2rem !important;
                font-size: 0.78rem !important;
            }

            .navbar-hero .nav-desktop-brand-right {
                position: absolute !important;
                left: auto !important;
                right: 1.5rem !important;
            }

            .navbar-hero .nav-pill-user {
                position: absolute !important;
                left: calc(50% + 10rem);
                right: auto !important;
            }

            .navbar-hero .nav-pill-login {
                position: absolute !important;
                left: calc(50% + 10rem);
                right: auto !important;
            }

            .navbar-hero .nav-pill {
                gap: 1.25rem !important;
                padding: 0.65rem 1.5rem !important;
            }

            .navbar-hero .nav-pill > a,
            .navbar-hero .nav-pill > div > button {
                min-height: 2rem !important;
                font-size: 0.75rem !important;
            }
        }

        #mobile-toggle-btn,
        #mobile-menu {
            background-color: #3b82f6 !important;
        }

        #mobile-menu > div > a,
        #mobile-menu > div > div a,
        #mobile-menu > div > div button {
            color: #ffffff !important;
        }

        #mobile-menu > div > a:hover,
        #mobile-menu > div > div a:hover,
        #mobile-menu > div > div button:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.16) !important;
        }
    </style>
</head>
<body class="@yield('body-class','') bg-slate-50 flex flex-col min-h-screen font-sans">
    <div class="content-wrapper">
        @if(!in_array(Route::currentRouteName(), ['login', 'register', 'login.perform', 'forgot-password', 'reset-password']))
            <x-navbar />
        @endif

        <main class="flex-grow pt-4">
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-slate-900 text-slate-200">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">


            <div class="text-center text-xs text-slate-400 sm:text-sm">
                Copyright © {{ date('Y') }} Inkubator Bisnis Institut Asia
            </div>
        </div>
        </footer>
    </div>

    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>

    <script>
    // Fallback modal controls if Alpine isn't available yet
    document.addEventListener('click', function(e){
        // open buttons
        var btn = e.target.closest && e.target.closest('button');
        if (!btn) return;
        if (btn.matches && btn.matches('.js-open-modal, button[data-open-modal]')){
            var modal = document.getElementById('reportModal');
            if (!modal) return;
            // remove x-cloak so CSS can show it
            modal.removeAttribute('x-cloak');
            modal.classList.add('js-open');
            return;
        }
        // close buttons
        if (btn.matches && btn.matches('.js-modal-close')){
            var modal = document.getElementById('reportModal');
            if (!modal) return;
            modal.classList.remove('js-open');
            modal.setAttribute('x-cloak','');
            return;
        }
    });

    // overlay close
    document.addEventListener('click', function(e){
        if (e.target && e.target.matches && e.target.matches('[data-js-overlay]')){
            var modal = document.getElementById('reportModal');
            if (!modal) return;
            modal.classList.remove('js-open');
            modal.setAttribute('x-cloak','');
        }
    });
    </script>