@extends('layouts.app')

@section('title', 'MEA 2026')

@section('body-class', 'hero-active')

@section('content')
{{-- HERO SECTION CONTAINER --}}
<section class="relative z-0 min-h-screen bg-transparent overflow-hidden isolate" id="home">
    

    <div class="relative z-10 mx-auto w-full max-w-[1500px] px-4 py-6 lg:px-8">
        <div class="hero-content hero-small">
            {{-- Elemen konten tambahan dapat ditaruh di sini jika ada --}}
        </div>
    </div>

    {{-- TOMBOL CTA DI TENGAH LAYAR VIDEOTRON --}}
    <div class="hero-actions">
        <a href="/reports" class="hero-btn hero-btn-primary">Reports</a>
        <a href="#pengumuman" class="hero-btn hero-btn-secondary">Announcement</a>
    </div>

    <div class="hero-support-group">
        <span class="hero-support-label">supported by:</span>
        <div class="hero-support-logos">
            <img src="{{ asset('images/logo_pnmpeduli.svg') }}" alt="PNM Peduli">
            <img src="{{ asset('images/logo_asia.svg') }}" alt="Institut Asia">
            <img src="{{ asset('images/logo_inbis.svg') }}" alt="INBIS">
        </div>
    </div>
</section>

<style>
    #home {
        position: relative;
        min-height: 100vh;
        max-height: 100vh;
        background-color: #dfeaf2;
        background-image: url("{{ asset('images/bg_new.svg') }}");
        background-repeat: no-repeat;
        background-position: top center;
        background-size: cover;
        overflow: visible;
    }

    #home .hero-visuals {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
    }

    #home .hero-content {
        position: relative;
        z-index: 20;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        max-width: 50rem;
        min-height: 690px;
        padding-top: 9rem;
        margin-left: 3rem;
        text-align: left;
    }

    #home .hero-content h1 {
        margin: 0;
        color: #071a2d;
        font-size: clamp(3.6rem, 3.8vw, 5.6rem);
        line-height: 0.96;
        font-weight: 900;
        letter-spacing: -0.07em;
        text-transform: uppercase;
        text-shadow: none;
    }

    #home .hero-sub {
        display: block;
        max-width: 35rem;
        margin-top: 1.4rem;
        color: #071a2d;
        font-size: clamp(2.5rem, 2.6vw, 3.6rem);
        line-height: 1.08;
        font-weight: 700;
        letter-spacing: -0.04em;
    }

    #home .hero-content p {
        max-width: 40rem;
        margin: 1.5rem 0 0;
        color: #071a2d;
        font-size: clamp(1.65rem, 1.75vw, 2.3rem);
        line-height: 1.45;
        font-weight: 400;
        text-transform: none;
        letter-spacing: 1px;
        text-shadow: none;
    }

    /* DIUBAH: Mengatur Tombol CTA tepat berada di tengah videotron */
    #home .hero-actions {
        position: absolute;
        top: 66%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 30;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        width: auto;
        margin: 0;
    }

    #home .hero-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 150px;
        min-width: 150px;
        box-sizing: border-box;
        padding: 0.7rem 1.2rem;
        border-radius: 9999px;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, opacity 0.2s ease;
        box-shadow: 0 12px 24px rgba(29, 78, 216, 0.18);
    }

    #home .hero-btn:hover {
        transform: translateY(-1px);
        opacity: 0.96;
    }

    #home .hero-btn-primary {
        background: #ffffff;
        color: #000000;
        border: 1px solid rgba(255,255,255,0.8);
    }

    #home .hero-btn-secondary {
        background: #ffffff;
        border: 1px solid rgba(15,23,42,0.12);
        color: #071a2d;
        box-shadow: 0 12px 20px rgba(15,23,42,0.08);
    }

    #home .hero-support-group {
        position: absolute;
        left: 50%;
        bottom: 1.5rem;
        transform: translateX(-50%);
        z-index: 30;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 22rem;
        min-height: 5.5rem;
        margin: 0;
        padding: 0.6rem 0.9rem 0.75rem;
        text-align: center;
        background: rgba(255, 255, 255, 1);
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 1rem;
    }

    #home .hero-support-label {
        display: block;
        color: #334155;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: lowercase;
        letter-spacing: 0.01em;
    }

    #home .hero-support-logos {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: nowrap;
        gap: 0.5rem;
        margin-top: 0.2rem;
        width: 100%;
    }

    #home .hero-support-logos img {
        width: 72px;
        height: 42px;
        object-fit: contain;
        flex: 0 0 auto;
        margin: 0;
    }

    #home .hero-support-logos img:nth-child(1) {
        width: 68px;
        height: 40px;
    }

    #home .hero-support-logos img:nth-child(2) {
        width: 84px;
        height: 44px;
    }

    #home .hero-support-logos img:nth-child(3) {
        width: 92px;
        height: 46px;
    }

    #home .hero-brand-left,
    #home .hero-brand-right {
        position: absolute;
        top: 2.1rem;
        z-index: 25;
        width: auto;
        height: 2.2rem;
        object-fit: contain;
        pointer-events: none;
        margin-left: 1rem;
        margin-right: 1rem;
    }

    #home .hero-brand-left {
        left: 1rem;
    }

    #home .hero-brand-right {
        right: 1rem;
    }

    html {
        scroll-behavior: smooth;
    }

    #pengumuman {
        scroll-margin-top: 5rem;
    }

    @media (max-width: 640px) {
        html,
        body,
        .content-wrapper,
        main {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #home {
            width: 100vw !important;
            height: 100dvh !important;
            min-height: 100dvh !important;
            max-height: 100dvh !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: 0 !important;
            box-sizing: border-box !important;
            align-items: flex-start !important;
            background-image: url("{{ asset('images/bg_mobile.svg') }}") !important;
            background-size: 103% 103% !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            overflow: hidden !important;
        }

        #home .hero-brand-left,
        #home .hero-brand-right {
            display: none !important;
        }

        #home .hero-visuals {
            z-index: 2;
        }

        #home .hero-top-logos {
            top: 2.5%;
            left: 6%;
            right: 6%;
            z-index: 4;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 0.8rem;
        }

        #home .hero-top-logos img {
            max-height: 44px;
        }

        #home .hero-logo-danantara {
            width: 82px;
        }

        #home .hero-logo-pnm {
            width: 65px;
            margin-top: 5px;

        }

        #home .hero-support-group {
            position: absolute !important;
            left: 1rem !important;
            right: auto !important;
            bottom: 1.5rem !important;
            transform: none !important;
            z-index: 30;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: fit-content;
            max-width: calc(100vw - 2rem);
            margin: 0;
            padding: 0.5rem 0.6rem 0.35rem;
            background: #ffffff;
            border-radius: 0.9rem;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
        }

        #home .hero-support-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.68rem;
            text-align: center;
        }

        #home .hero-support-logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            width: fit-content;
            max-width: none;
            position: relative;
            z-index: 11;
        }

        #home .hero-support-logos img {
            width: 18vw;
            max-width: 72px;
            height: 30px;
            object-fit: contain;
            flex: 1 1 0;
        }

        #home .hero-support-logos img:nth-child(3) {
            width: 15vw;
            max-width: 58px;
        }

        #home .hero-people {
            right: 50%;
            bottom: 0%;
            transform: translateX(50%);
            width: min(92vw, 440px);
            max-height: 64%;
            z-index: 5;
        }

        .hero-content {
            position: relative !important;
            z-index: 20 !important;
            margin-top: 8rem !important;
            gap: 0.35rem !important;
        }

        .hero-content h1 {
            font-size: 2.25rem !important;
            line-height: 1.05 !important;
        }

        .hero-content .hero-sub {
            font-size: 1.55rem !important;
            line-height: 1.2 !important;
        }

        .hero-content p {
            font-size: 1.08rem !important;
            color: #000000 !important;
            line-height: 1.5 !important;
        }

        .hero-actions {
            position: absolute !important;
            top: 35% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 0.7rem !important;
            margin-top: 0 !important;
            width: auto !important;
        }

        .hero-btn {
            width: 5.8rem !important;
            min-width: 5.8rem !important;
            padding: 0.45rem 0.5rem !important;
            font-size: 0.72rem !important;
        }
    }

    @media (min-width: 641px) {
        #home .hero-support-group {
            left: clamp(1rem, 2vw, 2rem);
            bottom: 1.5rem;
            transform: none;
        }
    }
</style>

{{-- EVENT DETAILS SECTION --}}
@include('components.event-details')

@include('partials.announcement')
@endsection