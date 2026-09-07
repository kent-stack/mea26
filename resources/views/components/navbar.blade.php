<nav class="navbar-hero hidden md:block z-50 bg-transparent -mt-1 @if(in_array(Route::currentRouteName(), ['login', 'register', 'login.perform', 'forgot-password', 'reset-password'])) hidden @endif">
    <div class="mx-auto max-w-[1500px] px-0 pt-2 pb-5 lg:px-0">
        <div class="flex items-center justify-center">
            <div class="nav-pill nav-desktop-bar flex w-full items-center justify-between bg-white px-6 py-2 shadow-[0_12px_24px_rgba(30,76,180,0.18)]">
                <a href="/" class="nav-desktop-brand nav-desktop-brand-left flex items-center" aria-label="Danantara Indonesia">
                    <img src="{{ asset('images/logo_danantara (2).svg') }}" alt="Danantara Indonesia" class="h-9 w-auto object-contain">
                </a>

                <div class="nav-desktop-links flex items-center gap-6">
                    <a href="/" class="nav-pill-link text-black font-bold text-[0.82rem] tracking-[0.12em] hover:text-black transition">HOME</a>
                    <a href="/reports" class="nav-pill-link text-black font-bold text-[0.82rem] tracking-[0.12em] hover:text-black transition">REPORTS</a>
                    <a href="/module" class="nav-pill-link text-black font-bold text-[0.82rem] tracking-[0.12em] hover:text-black transition">MODULE</a>
                    <a href="/submit" class="nav-pill-link text-black font-bold text-[0.82rem] tracking-[0.12em] hover:text-black transition">SUBMIT</a>
                </div>

                @auth
                    <div class="nav-pill-user relative">
                        <button type="button" id="user-menu-button" class="nav-pill-user-btn flex items-center justify-center rounded-full p-1.5 text-black hover:text-black focus:outline-none transition bg-transparent border-0" aria-expanded="false" aria-controls="user-menu-dropdown" aria-label="User menu">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 21a8 8 0 0 0-16 0" />
                                <circle cx="12" cy="8" r="4" />
                            </svg>
                        </button>

                        <div id="user-menu-dropdown" class="absolute -right-20 top-12 hidden min-w-[210px] rounded-xl border border-slate-200 bg-white p-2 shadow-xl text-slate-800">
                            <div class="border-b border-slate-100 pb-2 text-center text-sm font-semibold text-slate-800">
                                Hi, {{ auth()->user()->is_admin ? 'Administrator' : (auth()->user()->username ?: auth()->user()->name) }}
                            </div>
                            <div class="mt-2">
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.reports.index') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">Reports</a>
                                    <a href="{{ route('admin.participants.index') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">Participants</a>
                                    <a href="{{ url('/module') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">Module</a>
                                    @if(auth()->user()->is_superadmin)
                                        <a href="{{ route('admin.users.create') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">Create User</a>
                                    @endif
                                @endif
                                @unless(auth()->user()->is_admin)
                                    <a href="{{ route('profile') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">Profile</a>
                                @endunless
                                <a href="{{ route('submitted.reports') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">{{ auth()->user()->is_admin ? 'Submitted Announcement' : 'Submitted Reports' }}</a>
                                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                    @csrf
                                    <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-600 transition">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="/login" class="nav-pill-link nav-pill-login text-black font-bold text-[0.82rem] tracking-[0.12em] hover:text-black transition">LOGIN</a>
                @endauth

                <a href="/" class="nav-desktop-brand nav-desktop-brand-right flex items-center" aria-label="PNM">
                    <img src="{{ asset('images/logo_pnm.svg') }}" alt="PNM" class="h-9 w-auto object-contain">
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Header -->
<header class="header-container md:hidden fixed inset-x-0 top-0 z-[60] bg-[#f3f4f6]/80 px-4 pt-4 pb-3 shadow-sm backdrop-blur-[1px] @if(in_array(Route::currentRouteName(), ['login', 'register', 'login.perform', 'forgot-password', 'reset-password'])) hidden @endif">
    <nav class="main-navigation flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_danantara (2).svg') }}" alt="Danantara Indonesia" class="h-8 w-auto object-contain">
            <img src="{{ asset('images/logo_pnm.svg') }}" alt="PNM" class="h-8 w-auto object-contain">
        </div>

        <div class="header-actions">
            <button type="button" id="mobile-toggle-btn" class="flex h-12 w-12 appearance-none items-center justify-center rounded-xl border-0 bg-[#2f8bf2] text-white shadow-none outline-none transition hover:bg-[#287be0] focus:outline-none focus:ring-0" aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>
</header>

<!-- Mobile Fullscreen Dropdown Menu -->
<div id="mobile-menu" class="mobile-menu md:hidden fixed inset-0 z-50 hidden @if(in_array(Route::currentRouteName(), ['login', 'register', 'login.perform', 'forgot-password', 'reset-password'])) hidden @endif" aria-hidden="true">
    <div class="absolute inset-0 bg-white/95 backdrop-blur-sm"></div>

    <div class="relative z-10 flex min-h-screen flex-col">
        <div class="flex justify-end px-5 pt-5">
            <button type="button" id="mobile-close-btn" class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-200 focus:outline-none" aria-label="Close menu">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>

        <nav class="flex flex-1 items-center justify-center px-6 pb-20">
            <div class="w-full max-w-sm space-y-3 text-center">
                <a href="/" class="block px-4 py-4 text-lg font-bold tracking-[0.12em] text-slate-800 transition hover:bg-slate-100">HOME</a>
                <a href="/reports" class="block px-4 py-4 text-lg font-bold tracking-[0.12em] text-slate-800 transition hover:bg-slate-100">REPORTS</a>
                <a href="/module" class="block px-4 py-4 text-lg font-bold tracking-[0.12em] text-slate-800 transition hover:bg-slate-100">MODULE</a>
                <a href="/submit" class="block px-4 py-4 text-lg font-bold tracking-[0.12em] text-slate-800 transition hover:bg-slate-100">SUBMIT</a>

                @auth
                    <div class="pt-1">
                        <button type="button" id="mobile-more-toggle" class="flex w-full items-center justify-center gap-2 px-4 py-4 text-center text-lg font-bold tracking-[0.12em] text-slate-800 transition hover:bg-slate-100" aria-expanded="false" aria-controls="mobile-more-menu">
                            <span>MORE</span>
                            <svg class="h-4 w-4 transition-transform duration-200" id="mobile-more-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M5 7l5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <div id="mobile-more-menu" class="mobile-more-menu hidden px-2 pb-2">
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.reports.index') }}" class="admin-mobile-link block px-4 py-3 text-base font-semibold text-slate-700 transition hover:bg-slate-100">MANAGE REPORTS</a>
                                <a href="{{ route('admin.participants.index') }}" class="admin-mobile-link block px-4 py-3 text-base font-semibold text-slate-700 transition hover:bg-slate-100">PARTICIPANTS</a>
                            @endif
                            @unless(auth()->user()->is_admin)
                                <a href="{{ route('profile') }}" class="admin-mobile-link block px-4 py-3 text-base font-semibold text-slate-700 transition hover:bg-slate-100">PROFILE</a>
                            @endunless
                            <a href="{{ route('submitted.reports') }}" class="admin-mobile-link block px-4 py-3 text-base font-semibold text-slate-700 transition hover:bg-slate-100">{{ auth()->user()->is_admin ? 'SUBMITTED ANNOUNCEMENT' : 'SUBMITTED REPORTS' }}</a>
                            @if(auth()->user()->is_superadmin)
                                <a href="{{ route('admin.users.create') }}" class="admin-mobile-link block px-4 py-3 text-base font-semibold text-slate-700 transition hover:bg-slate-100">CREATE USER</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="pt-1 text-center">
                                @csrf
                                <button type="submit" class="admin-mobile-link mx-auto block rounded-xl px-4 py-3 text-center text-base font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-600">LOGOUT</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" class="block px-4 py-4 text-lg font-bold tracking-[0.12em] text-slate-800 transition hover:bg-slate-100">LOGIN</a>
                @endauth
            </div>
        </nav>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileToggleBtn = document.getElementById('mobile-toggle-btn');
        const desktopNavbar = document.querySelector('.navbar-hero');

        if (desktopNavbar) {
            const updateDesktopNavbar = () => {
                if (window.matchMedia('(min-width: 641px)').matches) {
                    desktopNavbar.classList.toggle('is-scrolled', window.scrollY > 10);
                } else {
                    desktopNavbar.classList.remove('is-scrolled');
                }
            };

            window.addEventListener('scroll', updateDesktopNavbar, { passive: true });
            window.addEventListener('resize', updateDesktopNavbar);
            updateDesktopNavbar();
        }

        // Desktop user menu toggle
        if (userMenuButton && userMenuDropdown) {
            userMenuButton.addEventListener('click', function (event) {
                event.stopPropagation();
                const isHidden = userMenuDropdown.classList.toggle('hidden');
                userMenuButton.setAttribute('aria-expanded', String(!isHidden));
            });

            document.addEventListener('click', function (event) {
                if (!userMenuDropdown.contains(event.target) && !userMenuButton.contains(event.target)) {
                    userMenuDropdown.classList.add('hidden');
                    userMenuButton.setAttribute('aria-expanded', 'false');
                }
            });
        }

        const mobileCloseBtn = document.getElementById('mobile-close-btn');
        const mobileMoreToggle = document.getElementById('mobile-more-toggle');
        const mobileMoreMenu = document.getElementById('mobile-more-menu');
        const mobileMoreIcon = document.getElementById('mobile-more-icon');

        if (mobileMoreToggle && mobileMoreMenu && mobileMoreIcon) {
            mobileMoreToggle.addEventListener('click', function () {
                const isOpen = !mobileMoreMenu.classList.contains('hidden');
                mobileMoreMenu.classList.toggle('hidden');
                mobileMoreToggle.setAttribute('aria-expanded', String(!isOpen));
                mobileMoreIcon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        }

        // Mobile floating menu close when clicking outside
        if (mobileMenu && mobileToggleBtn) {
            const openMobileMenu = () => {
                mobileMenu.classList.remove('hidden');
                requestAnimationFrame(() => {
                    mobileMenu.classList.add('visible');
                });
                mobileMenu.setAttribute('aria-hidden', 'false');
                mobileToggleBtn.setAttribute('aria-expanded', 'true');
                document.body.classList.add('overflow-hidden');
            };

            const closeMobileMenu = () => {
                mobileMenu.classList.remove('visible');
                mobileMenu.setAttribute('aria-hidden', 'true');
                mobileToggleBtn.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => {
                    if (!mobileMenu.classList.contains('visible')) {
                        mobileMenu.classList.add('hidden');
                    }
                }, 260);
            };

            mobileToggleBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                if (mobileMenu.classList.contains('hidden')) {
                    openMobileMenu();
                } else {
                    closeMobileMenu();
                }
            });

            if (mobileCloseBtn) {
                mobileCloseBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    closeMobileMenu();
                });
            }

            mobileMenu.addEventListener('click', function (event) {
                if (event.target === mobileMenu) {
                    closeMobileMenu();
                }
            });

            document.addEventListener('click', function (event) {
                if (!mobileMenu.contains(event.target) && !mobileToggleBtn.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
                    closeMobileMenu();
                }
            });

            const mobileLinks = mobileMenu.querySelectorAll('a, button');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (link === mobileMoreToggle) {
                        return;
                    }

                    closeMobileMenu();
                });
            });
        }
    });
</script>

<style>
    .mobile-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-18px);
        transition: opacity 0.28s ease, transform 0.28s ease, visibility 0.28s ease;
    }

    .mobile-menu.visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    @media (max-width: 640px) {
        .admin-mobile-link {
            display: block !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            max-width: 100% !important;
        }

        .mobile-more-menu {
            display: block;
        }

        .mobile-more-menu.hidden {
            display: none;
        }
    }
</style>
