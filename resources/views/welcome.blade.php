<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Streamline your complaint and service request tracking with our comprehensive management system. Submit, track, and resolve issues efficiently.">
    <title>Complaint & Service Request Tracking System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ============================================
           DESIGN TOKENS
           ============================================ */
        :root {
            --c-navy:       #0f172a;
            --c-navy-light: #1e293b;
            --c-navy-mid:   #334155;
            --c-slate:      #475569;
            --c-slate-lt:   #94a3b8;
            --c-teal:       #0d9488;
            --c-teal-dark:  #0f766e;
            --c-teal-light: #14b8a6;
            --c-emerald:    #059669;
            --c-emerald-lt: #10b981;
            --c-gold:       #f59e0b;
            --c-gold-light: #fbbf24;
            --c-white:      #ffffff;
            --c-off-white:  #f8fafc;
            --c-danger:     #ef4444;

            --g-hero:     linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            --g-teal:     linear-gradient(135deg, #0d9488 0%, #059669 100%);
            --g-teal-rev: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            --g-gold:     linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --g-dark:     linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --g-mesh:     radial-gradient(ellipse at 20% 50%, rgba(13,148,136,0.15) 0%, transparent 50%),
                          radial-gradient(ellipse at 80% 20%, rgba(5,150,105,0.1) 0%, transparent 50%),
                          radial-gradient(ellipse at 50% 80%, rgba(245,158,11,0.06) 0%, transparent 50%);

            --font-heading: 'Inter', system-ui, sans-serif;
            --font-body:    'Plus Jakarta Sans', system-ui, sans-serif;

            --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-spring:   cubic-bezier(0.34, 1.56, 0.64, 1);

            --shadow-sm:  0 2px 8px rgba(0,0,0,0.08);
            --shadow-md:  0 8px 30px rgba(0,0,0,0.12);
            --shadow-lg:  0 20px 60px rgba(0,0,0,0.15);
            --shadow-xl:  0 30px 80px rgba(0,0,0,0.2);
            --shadow-glow: 0 0 40px rgba(13,148,136,0.3);
        }

        /* ============================================
           CUSTOM CURSOR
           ============================================ */
        body { cursor: none; }
        a, button, input, textarea, select, .cursor-pointer, .bento-item, .feature-card, .faq-question { cursor: none; }
        
        .cursor-dot, .cursor-outline {
            position: fixed;
            top: 0;
            left: 0;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            z-index: 9999;
            pointer-events: none;
        }

        .cursor-dot {
            width: 8px;
            height: 8px;
            background-color: var(--c-teal-light);
            box-shadow: 0 0 10px var(--c-teal-light), 0 0 20px var(--c-teal);
        }

        .cursor-outline {
            width: 40px;
            height: 40px;
            border: 2px solid rgba(20, 184, 166, 0.5);
            transition: width 0.2s, height 0.2s, background-color 0.2s;
        }

        .cursor-outline.hovering {
            width: 60px;
            height: 60px;
            background-color: rgba(20, 184, 166, 0.1);
            border-color: rgba(20, 184, 166, 0.8);
        }
        
        @media (max-width: 768px) {
            body, a, button, input, textarea, select, .cursor-pointer, .bento-item, .feature-card, .faq-question { cursor: auto; }
            .cursor-dot, .cursor-outline { display: none !important; }
        }

        /* ============================================
           RESET & BASE
           ============================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html {
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: var(--font-body);
            color: var(--c-navy);
            background: var(--c-off-white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        img { max-width: 100%; height: auto; display: block; }
        a { text-decoration: none; color: inherit; }

        /* ============================================
           UTILITY CLASSES
           ============================================ */
        .container-xl {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .gradient-text {
            background: var(--g-teal);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-gold {
            background: var(--g-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-label {
            font-family: var(--font-heading);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--c-teal);
            margin-bottom: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 2px;
            background: var(--g-teal);
            border-radius: 2px;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 800;
            line-height: 1.15;
            color: var(--c-navy);
            margin-bottom: 20px;
        }

        .section-subtitle {
            font-size: 1.15rem;
            color: var(--c-slate);
            max-width: 600px;
            line-height: 1.7;
        }

        /* ============================================
           SCROLL ANIMATIONS
           ============================================ */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s var(--ease-out-expo), transform 0.8s var(--ease-out-expo);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-60px);
            transition: opacity 0.8s var(--ease-out-expo), transform 0.8s var(--ease-out-expo);
        }
        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(60px);
            transition: opacity 0.8s var(--ease-out-expo), transform 0.8s var(--ease-out-expo);
        }
        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-scale {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.8s var(--ease-out-expo), transform 0.8s var(--ease-out-expo);
        }
        .reveal-scale.visible {
            opacity: 1;
            transform: scale(1);
        }

        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }

        /* ============================================
           NAVBAR
           ============================================ */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 20px 0;
            transition: all 0.4s var(--ease-out-expo);
        }

        .navbar.scrolled {
            padding: 12px 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 4px 30px rgba(0,0,0,0.2);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--c-white);
        }

        .navbar-brand-icon {
            width: 40px;
            height: 40px;
            background: var(--g-teal);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: white;
            box-shadow: 0 4px 15px rgba(13,148,136,0.4);
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .navbar-links a {
            font-size: 0.9rem;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            transition: color 0.3s ease;
            position: relative;
        }

        .navbar-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--g-teal);
            border-radius: 2px;
            transition: width 0.3s var(--ease-out-expo);
        }

        .navbar-links a:hover {
            color: var(--c-white);
        }

        .navbar-links a:hover::after {
            width: 100%;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 10px 24px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s var(--ease-out-expo);
            position: relative;
            overflow: hidden;
        }

        .btn-ghost {
            background: transparent;
            color: rgba(255,255,255,0.8);
            border: 1px solid rgba(255,255,255,0.15);
        }

        .btn-ghost:hover {
            color: var(--c-white);
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--g-teal);
            color: var(--c-white);
            box-shadow: 0 4px 15px rgba(13,148,136,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13,148,136,0.4);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-lg {
            padding: 16px 36px;
            font-size: 1rem;
            border-radius: 16px;
        }

        .btn-outline-white {
            background: transparent;
            color: var(--c-white);
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn-outline-white:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.6);
            transform: translateY(-2px);
        }

        .btn-dark {
            background: var(--c-navy);
            color: var(--c-white);
            box-shadow: 0 4px 15px rgba(15,23,42,0.3);
        }

        .btn-dark:hover {
            background: var(--c-navy-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15,23,42,0.4);
        }

        /* Mobile Menu */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 4px;
        }

        /* ============================================
           BENTO HERO SECTION
           ============================================ */
        .hero-bento {
            min-height: 100vh;
            background: var(--g-hero);
            position: relative;
            display: flex;
            align-items: center;
            padding: 140px 0 80px;
            overflow: hidden;
        }
        .hero-bento::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--g-mesh);
            pointer-events: none;
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: auto;
            gap: 24px;
            position: relative;
            z-index: 2;
        }
        .bento-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 32px;
            padding: 40px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transition: transform 0.5s var(--ease-out-expo), box-shadow 0.5s var(--ease-out-expo);
            overflow: hidden;
            position: relative;
        }
        .bento-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border-color: rgba(13, 148, 136, 0.3);
        }
        .bento-main {
            grid-column: span 8;
            grid-row: span 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, rgba(30,41,59,0.4) 0%, rgba(15,23,42,0.8) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }
        .bento-visual {
            grid-column: span 4;
            grid-row: span 3;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 1000px;
            background: var(--g-dark);
        }
        .bento-visual::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: conic-gradient(from 180deg at 50% 50%, #0d9488 0deg, #f59e0b 180deg, #0d9488 360deg);
            animation: rotateBg 10s linear infinite;
            opacity: 0.15;
            z-index: 0;
        }
        @keyframes rotateBg {
            100% { transform: rotate(360deg); }
        }
        .bento-visual-inner {
            width: 90%;
            height: 80%;
            background: rgba(255,255,255,0.05);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.1);
            transform: rotateX(15deg) rotateY(-15deg);
            transform-style: preserve-3d;
            box-shadow: -20px 30px 50px rgba(0,0,0,0.5);
            transition: transform 0.6s var(--ease-out-expo);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        .bento-visual:hover .bento-visual-inner {
            transform: rotateX(5deg) rotateY(-5deg);
        }
        .bento-visual-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        .bento-stat {
            grid-column: span 4;
            grid-row: span 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }
        .bento-stat.gradient {
            background: var(--g-teal);
            border: none;
        }
        .bento-stat.gradient h2, .bento-stat.gradient p {
            color: var(--c-white);
        }
        .bento-stat h2 {
            font-family: var(--font-heading);
            font-size: 3rem;
            font-weight: 900;
            color: var(--c-white);
            line-height: 1;
            margin-bottom: 8px;
        }
        .bento-stat p {
            color: var(--c-slate-lt);
            font-weight: 500;
            font-size: 1.1rem;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(13,148,136,0.15);
            border: 1px solid rgba(13,148,136,0.3);
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--c-teal-light);
            margin-bottom: 32px;
            width: fit-content;
        }
        .hero-title {
            font-family: var(--font-heading);
            font-size: clamp(2.5rem, 4vw, 4rem);
            font-weight: 900;
            line-height: 1.1;
            color: var(--c-white);
            margin-bottom: 24px;
            letter-spacing: -1px;
        }
        .hero-title .gradient-text {
            background: var(--g-teal);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-description {
            font-size: 1.1rem;
            color: var(--c-slate-lt);
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 600px;
        }
        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        @media (max-width: 1024px) {
            .bento-main { grid-column: span 12; }
            .bento-visual { grid-column: span 12; grid-row: span 2; min-height: 400px; }
            .bento-stat { grid-column: span 6; }
        }
        @media (max-width: 768px) {
            .bento-stat { grid-column: span 12; }
            .hero-title { font-size: 2.2rem; }
            .hero-bento { padding: 120px 0 60px; }
        }

        /* ============================================
           LOGOS / TRUST SECTION
           ============================================ */
        .trust-section {
            padding: 60px 0;
            background: var(--c-off-white);
            border-bottom: 1px solid rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .trust-label {
            text-align: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--c-slate-lt);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 32px;
        }

        .trust-logos-wrapper {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .trust-logos-wrapper::before,
        .trust-logos-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            width: 100px;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }

        .trust-logos-wrapper::before {
            left: 0;
            background: linear-gradient(to right, var(--c-off-white) 0%, transparent 100%);
        }

        .trust-logos-wrapper::after {
            right: 0;
            background: linear-gradient(to left, var(--c-off-white) 0%, transparent 100%);
        }

        .trust-logos {
            display: flex;
            align-items: center;
            gap: 64px;
            width: max-content;
            animation: scrollLogos 25s linear infinite;
        }

        .trust-logos:hover {
            animation-play-state: paused;
        }

        @keyframes scrollLogos {
            from { transform: translateX(0); }
            to { transform: translateX(calc(-50% - 32px)); }
        }

        .trust-logo {
            font-family: var(--font-heading);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--c-slate-lt);
            opacity: 0.5;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trust-logo:hover {
            opacity: 0.8;
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */
        .features-section {
            padding: 120px 0;
            background: var(--c-white);
            position: relative;
        }

        .features-header {
            text-align: center;
            margin-bottom: 72px;
        }

        .features-header .section-subtitle {
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
        }

        .feature-card {
            background: var(--c-white);
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 20px;
            padding: 36px 28px;
            text-align: center;
            transition: all 0.5s var(--ease-out-expo);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--g-teal);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s var(--ease-out-expo);
        }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card-image {
            width: 100%;
            height: 160px;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .feature-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s var(--ease-out-expo);
        }

        .feature-card:hover .feature-card-image img {
            transform: scale(1.08);
        }

        .feature-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.3rem;
            color: white;
        }

        .feature-card-icon.teal  { background: var(--g-teal); }
        .feature-card-icon.gold  { background: var(--g-gold); }
        .feature-card-icon.emerald { background: linear-gradient(135deg, var(--c-emerald) 0%, var(--c-emerald-lt) 100%); }

        .feature-card h3 {
            font-family: var(--font-heading);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--c-navy);
            margin-bottom: 12px;
        }

        .feature-card p {
            font-size: 0.93rem;
            color: var(--c-slate);
            line-height: 1.7;
        }

        /* ============================================
           HOW IT WORKS
           ============================================ */
        .how-section {
            padding: 120px 0;
            background: var(--c-off-white);
            position: relative;
        }

        .how-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .how-header .section-subtitle {
            margin: 0 auto;
        }

        .how-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            position: relative;
        }

        .how-steps::before {
            content: '';
            position: absolute;
            top: 52px;
            left: 16%;
            right: 16%;
            height: 3px;
            background: linear-gradient(90deg, var(--c-teal), var(--c-emerald), var(--c-gold));
            border-radius: 3px;
        }

        .how-step {
            text-align: center;
            position: relative;
        }

        .how-step-number {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-heading);
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--c-white);
            margin: 0 auto 28px;
            position: relative;
            z-index: 2;
            box-shadow: 0 8px 25px rgba(13,148,136,0.3);
        }

        .how-step:nth-child(1) .how-step-number { background: var(--g-teal); }
        .how-step:nth-child(2) .how-step-number { background: linear-gradient(135deg, var(--c-emerald), var(--c-emerald-lt)); }
        .how-step:nth-child(3) .how-step-number { background: var(--g-gold); }

        .how-step-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            background: var(--c-white);
            color: var(--c-teal);
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s var(--ease-out-expo);
        }

        .how-step:hover .how-step-icon {
            transform: scale(1.05);
            box-shadow: var(--shadow-md);
        }

        .how-step h3 {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--c-navy);
            margin-bottom: 12px;
        }

        .how-step p {
            font-size: 0.95rem;
            color: var(--c-slate);
            line-height: 1.7;
            max-width: 280px;
            margin: 0 auto;
        }

        /* ============================================
           FEATURE SHOWCASE (Alternating sections)
           ============================================ */
        .showcase-section {
            padding: 120px 0;
            position: relative;
        }

        .showcase-section:nth-child(even) {
            background: var(--c-off-white);
        }

        .showcase-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .showcase-grid.reverse .showcase-image {
            order: 2;
        }

        .showcase-grid.reverse .showcase-content {
            order: 1;
        }

        .showcase-image {
            position: relative;
        }

        .showcase-image img {
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            transition: transform 0.6s var(--ease-out-expo);
        }

        .showcase-image:hover img {
            transform: scale(1.03);
        }

        .showcase-image-accent {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 16px;
            left: 16px;
            background: var(--g-teal);
            border-radius: 24px;
            z-index: -1;
            opacity: 0.15;
        }

        .showcase-content .section-title {
            font-size: clamp(1.8rem, 3vw, 2.4rem);
        }

        .showcase-features-list {
            list-style: none;
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .showcase-features-list li {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            font-size: 0.98rem;
            color: var(--c-slate);
            line-height: 1.6;
        }

        .showcase-features-list li i {
            color: var(--c-teal);
            margin-top: 4px;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* ============================================
           STATS SECTION
           ============================================ */
        .stats-section {
            padding: 100px 0;
            background: var(--c-navy);
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--g-mesh);
            pointer-events: none;
        }

        .stats-bg-image {
            position: absolute;
            inset: 0;
            opacity: 0.08;
        }

        .stats-bg-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .stats-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .stats-header .section-title {
            color: var(--c-white);
        }

        .stats-header .section-subtitle {
            color: var(--c-slate-lt);
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
            position: relative;
            z-index: 2;
        }

        .stat-card {
            text-align: center;
            padding: 40px 24px;
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px;
            transition: all 0.4s var(--ease-out-expo);
        }

        .stat-card:hover {
            background: rgba(255,255,255,0.08);
            transform: translateY(-8px);
            border-color: rgba(13,148,136,0.3);
        }

        .stat-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.2rem;
            background: var(--g-teal);
            color: white;
        }

        .stat-card-value {
            font-family: var(--font-heading);
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--c-white);
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-card-label {
            font-size: 0.95rem;
            color: var(--c-slate-lt);
        }

        /* ============================================
           FAQ SECTION
           ============================================ */
        .faq-section {
            padding: 120px 0;
            background: var(--c-white);
            position: relative;
        }
        .faq-header {
            text-align: center;
            margin-bottom: 64px;
        }
        .faq-header .section-subtitle {
            margin: 0 auto;
        }
        .faq-grid {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .faq-item {
            background: var(--c-off-white);
            border: 1px solid rgba(0,0,0,0.04);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .faq-item:hover {
            border-color: rgba(13,148,136,0.3);
            box-shadow: var(--shadow-sm);
        }
        .faq-question {
            padding: 24px 32px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--c-navy);
            user-select: none;
        }
        .faq-icon {
            color: var(--c-teal);
            font-size: 1.2rem;
            transition: transform 0.4s var(--ease-out-expo);
        }
        .faq-item.active .faq-icon {
            transform: rotate(45deg);
        }
        .faq-answer {
            padding: 0 32px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s var(--ease-out-expo), padding 0.4s var(--ease-out-expo);
            color: var(--c-slate);
            font-size: 0.98rem;
            line-height: 1.7;
        }
        .faq-item.active .faq-answer {
            padding: 0 32px 24px;
            max-height: 300px;
        }

        /* ============================================
           CTA SECTION
           ============================================ */
        .cta-section {
            padding: 120px 0;
            background: var(--c-navy);
            position: relative;
            overflow: hidden;
        }

        .cta-bg {
            position: absolute;
            inset: 0;
            opacity: 0.2;
        }

        .cta-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-content .section-title {
            color: var(--c-white);
            font-size: clamp(2rem, 4.5vw, 3.5rem);
            margin-bottom: 20px;
        }

        .cta-content .section-subtitle {
            color: var(--c-slate-lt);
            margin: 0 auto 40px;
            max-width: 550px;
        }

        .cta-actions {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .cta-note {
            margin-top: 24px;
            font-size: 0.85rem;
            color: var(--c-slate-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .cta-note i {
            color: var(--c-emerald-lt);
        }

        /* ============================================
           FOOTER
           ============================================ */
        .footer {
            background: #0b1120;
            padding: 80px 0 40px;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 60px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-brand-icon {
            width: 40px;
            height: 40px;
            background: var(--g-teal);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
        }

        .footer-brand span {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--c-white);
        }

        .footer-description {
            font-size: 0.93rem;
            color: var(--c-slate-lt);
            line-height: 1.7;
            margin-bottom: 24px;
            max-width: 320px;
        }

        .footer-socials {
            display: flex;
            gap: 12px;
        }

        .footer-social-link {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-slate-lt);
            transition: all 0.3s ease;
        }

        .footer-social-link:hover {
            background: var(--g-teal);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .footer-col-title {
            font-family: var(--font-heading);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--c-white);
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links a {
            font-size: 0.9rem;
            color: var(--c-slate-lt);
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--c-teal-light);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-copyright {
            font-size: 0.85rem;
            color: var(--c-slate);
        }

        .footer-bottom-links {
            display: flex;
            gap: 24px;
        }

        .footer-bottom-links a {
            font-size: 0.85rem;
            color: var(--c-slate);
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: var(--c-teal-light);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 48px;
            }

            .hero-description { margin: 0 auto 40px; }
            .hero-actions { justify-content: center; }
            .hero-stats-row { justify-content: center; }
            .hero-float-card { display: none; }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .how-steps::before { display: none; }

            .showcase-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .showcase-grid.reverse .showcase-image { order: unset; }
            .showcase-grid.reverse .showcase-content { order: unset; }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .navbar-links { display: none; }
            .mobile-toggle { display: block; }

            .hero { padding: 100px 0 60px; }
            .hero-title { letter-spacing: -0.5px; }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .how-steps {
                grid-template-columns: 1fr;
                gap: 48px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats-row {
                flex-direction: column;
                gap: 16px;
                align-items: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 36px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-actions {
                flex-direction: column;
                width: 100%;
            }

            .hero-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .cta-actions {
                flex-direction: column;
                align-items: center;
            }

            .cta-actions .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- ========================================
         CUSTOM CURSOR
         ======================================== -->
    <div class="cursor-dot" id="cursor-dot"></div>
    <div class="cursor-outline" id="cursor-outline"></div>

    <!-- ========================================
         NAVBAR
         ======================================== -->
    <nav class="navbar" id="mainNavbar">
        <div class="container-xl">
            <div class="navbar-inner">
                <a href="/" class="navbar-brand">
                    <div class="navbar-brand-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <span>CSRTS</span>
                </a>

                <ul class="navbar-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#stats">Stats</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>

                <div class="navbar-actions">
                    @auth
                        @if(Auth::user() && Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-rocket"></i> Dashboard
                            </a>
                        @elseif(Auth::user() && Auth::user()->isStaff())
                            <a href="{{ route('staff.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-rocket"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-rocket"></i> Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @endauth
                </div>

                <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- ========================================
         HERO BENTO
         ======================================== -->
    <section class="hero-bento" id="hero">
        <div id="tsparticles" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></div>
        <div class="container-xl">
            <div class="bento-grid">
                <!-- Main Box -->
                <div class="bento-item bento-main reveal">
                    <div class="hero-badge">
                        <i class="fas fa-bolt" style="color: var(--c-gold)"></i> Next-Gen Resolution
                    </div>
                    <h1 class="hero-title">
                        Resolve Issues<br>
                        <span class="gradient-text">Faster & Smarter</span>
                    </h1>
                    <p class="hero-description">
                        The all-in-one platform to submit, track, and resolve complaints with real-time
                        updates, intelligent routing, and powerful analytics.
                    </p>
                    <div class="hero-actions">
                        @auth
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-rocket"></i> Go to Dashboard
                                </a>
                            @elseif(Auth::user() && Auth::user()->isStaff())
                                <a href="{{ route('staff.dashboard') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-rocket"></i> Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-rocket"></i> Go to Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-arrow-right"></i> Start Free Today
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-white btn-lg">
                                <i class="fas fa-play"></i> Sign In
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- 3D Graphic Box -->
                <div class="bento-item bento-visual reveal stagger-1">
                    <div class="bento-visual-inner">
                        <img src="{{ asset('images/landing/hero-abstract.png') }}" alt="Abstract Dashboard Graphic" loading="eager" onerror="this.src='{{ asset('images/landing/hero-dashboard-new.png') }}'">
                    </div>
                </div>

                <!-- Stats Box 1 -->
                <div class="bento-item bento-stat reveal stagger-2">
                    <h2>99.9%</h2>
                    <p>Uptime SLA</p>
                </div>

                <!-- Stats Box 2 -->
                <div class="bento-item bento-stat gradient reveal stagger-3">
                    <h2>&lt; 5min</h2>
                    <p>Avg. Response</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         TRUST / LOGOS
         ======================================== -->
    <section class="trust-section">
        <div class="container-xl" style="position: relative;">
            <div class="trust-label reveal">Trusted by organizations worldwide</div>
            <div class="trust-logos-wrapper reveal">
                <div class="trust-logos">
                    <div class="trust-logo"><i class="fas fa-building"></i> Enterprise Co</div>
                    <div class="trust-logo"><i class="fas fa-university"></i> GovServices</div>
                    <div class="trust-logo"><i class="fas fa-hospital"></i> HealthCare+</div>
                    <div class="trust-logo"><i class="fas fa-graduation-cap"></i> EduTrust</div>
                    <div class="trust-logo"><i class="fas fa-shield-alt"></i> SecureOrg</div>
                    <!-- Duplicate for infinite loop -->
                    <div class="trust-logo"><i class="fas fa-building"></i> Enterprise Co</div>
                    <div class="trust-logo"><i class="fas fa-university"></i> GovServices</div>
                    <div class="trust-logo"><i class="fas fa-hospital"></i> HealthCare+</div>
                    <div class="trust-logo"><i class="fas fa-graduation-cap"></i> EduTrust</div>
                    <div class="trust-logo"><i class="fas fa-shield-alt"></i> SecureOrg</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         FEATURES
         ======================================== -->
    <section class="features-section" id="features">
        <div class="container-xl">
            <div class="features-header">
                <div class="section-label reveal">Features</div>
                <h2 class="section-title reveal">Everything You Need to <span class="gradient-text">Manage Complaints</span></h2>
                <p class="section-subtitle reveal">Powerful tools designed for every step of the complaint lifecycle — from submission to resolution and reporting.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card reveal stagger-1">
                    <div class="feature-card-image">
                        <img src="{{ asset('images/landing/feature-tracking.png') }}" alt="Easy Submission" loading="lazy">
                    </div>
                    <div class="feature-card-icon teal"><i class="fas fa-paper-plane"></i></div>
                    <h3>Easy Submission</h3>
                    <p>Submit complaints quickly with our intuitive form. Categorize, prioritize, and attach evidence in seconds.</p>
                </div>

                <div class="feature-card reveal stagger-2">
                    <div class="feature-card-image">
                        <img src="{{ asset('images/landing/feature-analytics-modern.png') }}" alt="Real-time Tracking" loading="lazy">
                    </div>
                    <div class="feature-card-icon emerald"><i class="fas fa-chart-line"></i></div>
                    <h3>Real-time Tracking</h3>
                    <p>Monitor complaint status live with instant notifications and transparent progress updates throughout the process.</p>
                </div>

                <div class="feature-card reveal stagger-3">
                    <div class="feature-card-image">
                        <img src="{{ asset('images/landing/feature-collaboration-new.png') }}" alt="Role-based Access" loading="lazy">
                    </div>
                    <div class="feature-card-icon gold"><i class="fas fa-users-cog"></i></div>
                    <h3>Role-based Access</h3>
                    <p>Granular permissions for Users, Staff, and Admins ensure everyone sees exactly what they need — nothing more.</p>
                </div>

                <div class="feature-card reveal stagger-4">
                    <div class="feature-card-image">
                        <img src="{{ asset('images/landing/hero-abstract.png') }}" alt="Smart Reports" loading="lazy">
                    </div>
                    <div class="feature-card-icon teal"><i class="fas fa-file-chart-line"></i></div>
                    <h3>Smart Reports</h3>
                    <p>Generate actionable analytics and export data to identify trends, bottlenecks, and areas for improvement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         HOW IT WORKS
         ======================================== -->
    <section class="how-section" id="how-it-works">
        <div class="container-xl">
            <div class="how-header">
                <div class="section-label reveal">How It Works</div>
                <h2 class="section-title reveal">Three Simple Steps to <span class="gradient-text">Resolution</span></h2>
                <p class="section-subtitle reveal">Our streamlined process ensures every complaint is handled efficiently from start to finish.</p>
            </div>

            <div class="how-steps">
                <div class="how-step reveal stagger-1">
                    <div class="how-step-number">1</div>
                    <div class="how-step-icon"><i class="fas fa-edit"></i></div>
                    <h3>Submit Your Complaint</h3>
                    <p>Fill out a simple form with your issue details. Choose a category and priority level for faster routing.</p>
                </div>

                <div class="how-step reveal stagger-2">
                    <div class="how-step-number">2</div>
                    <div class="how-step-icon"><i class="fas fa-cogs"></i></div>
                    <h3>We Process & Assign</h3>
                    <p>Your complaint is automatically routed to the right staff member who begins working on a resolution immediately.</p>
                </div>

                <div class="how-step reveal stagger-3">
                    <div class="how-step-number">3</div>
                    <div class="how-step-icon"><i class="fas fa-check-circle"></i></div>
                    <h3>Track & Resolve</h3>
                    <p>Follow progress in real-time through your dashboard. Get notified the moment your issue is resolved.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         FEATURE SHOWCASE 1 — Tracking
         ======================================== -->
    <section class="showcase-section">
        <div class="container-xl">
            <div class="showcase-grid">
                <div class="showcase-image reveal-left">
                    <div class="showcase-image-accent"></div>
                    <img src="{{ asset('images/landing/feature-tracking.png') }}" alt="Real-time Tracking Dashboard" loading="lazy">
                </div>
                <div class="showcase-content reveal-right">
                    <div class="section-label">Real-time Tracking</div>
                    <h2 class="section-title">Never Lose Sight of Your <span class="gradient-text">Complaints</span></h2>
                    <p class="section-subtitle">Our live tracking dashboard gives you complete visibility into every complaint's journey from submission to resolution.</p>
                    <ul class="showcase-features-list">
                        <li><i class="fas fa-check-circle"></i> Live status updates with progress indicators</li>
                        <li><i class="fas fa-check-circle"></i> Instant email notifications on status changes</li>
                        <li><i class="fas fa-check-circle"></i> Complete complaint history and audit trail</li>
                        <li><i class="fas fa-check-circle"></i> Filter and search across all complaints</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         FEATURE SHOWCASE 2 — Analytics
         ======================================== -->
    <section class="showcase-section">
        <div class="container-xl">
            <div class="showcase-grid reverse">
                <div class="showcase-image reveal-right">
                    <div class="showcase-image-accent"></div>
                    <img src="{{ asset('images/landing/feature-analytics-modern.png') }}" alt="Analytics Dashboard" loading="lazy">
                </div>
                <div class="showcase-content reveal-left">
                    <div class="section-label">Analytics & Reports</div>
                    <h2 class="section-title">Data-driven Decisions with <span class="gradient-text">Smart Analytics</span></h2>
                    <p class="section-subtitle">Transform raw data into actionable insights. Understand trends, measure performance, and continuously improve.</p>
                    <ul class="showcase-features-list">
                        <li><i class="fas fa-check-circle"></i> Visual dashboards with real-time data charts</li>
                        <li><i class="fas fa-check-circle"></i> Export reports in multiple formats</li>
                        <li><i class="fas fa-check-circle"></i> Track resolution times and staff performance</li>
                        <li><i class="fas fa-check-circle"></i> Identify recurring issues and trends</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         STATS
         ======================================== -->
    <section class="stats-section" id="stats">
        <div class="stats-bg-image">
            <img src="{{ asset('images/landing/testimonial-bg.png') }}" alt="" loading="lazy">
        </div>

        <div class="container-xl">
            <div class="stats-header">
                <div class="section-label reveal" style="color: var(--c-teal-light);">By the Numbers</div>
                <h2 class="section-title reveal">Built for <span class="gradient-text">Performance</span></h2>
                <p class="section-subtitle reveal">Numbers that reflect our commitment to efficiency and excellence.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card reveal stagger-1">
                    <div class="stat-card-icon"><i class="fas fa-check-double"></i></div>
                    <div class="stat-card-value"><span class="counter" data-target="99">0</span>%</div>
                    <div class="stat-card-label">Resolution Rate</div>
                </div>

                <div class="stat-card reveal stagger-2">
                    <div class="stat-card-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-card-value">&lt;<span class="counter" data-target="5">0</span>min</div>
                    <div class="stat-card-label">Avg. Response Time</div>
                </div>

                <div class="stat-card reveal stagger-3">
                    <div class="stat-card-icon"><i class="fas fa-headset"></i></div>
                    <div class="stat-card-value"><span class="counter" data-target="24">0</span>/7</div>
                    <div class="stat-card-label">Support Available</div>
                </div>

                <div class="stat-card reveal stagger-4">
                    <div class="stat-card-icon"><i class="fas fa-star"></i></div>
                    <div class="stat-card-value"><span class="counter" data-target="4">0</span>.9</div>
                    <div class="stat-card-label">User Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         FAQ
         ======================================== -->
    <section class="faq-section" id="faq">
        <div class="container-xl">
            <div class="faq-header">
                <div class="section-label reveal">FAQ</div>
                <h2 class="section-title reveal">Frequently Asked <span class="gradient-text">Questions</span></h2>
                <p class="section-subtitle reveal">Find answers to common questions about our platform and how it can help you.</p>
            </div>

            <div class="faq-grid">
                <div class="faq-item reveal stagger-1">
                    <div class="faq-question">
                        How long does it take to set up?
                        <i class="fas fa-plus faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        Setting up your account takes less than 5 minutes. You can start managing complaints and assigning roles immediately after registration. We provide a step-by-step onboarding guide.
                    </div>
                </div>

                <div class="faq-item reveal stagger-2">
                    <div class="faq-question">
                        Can I export data and reports?
                        <i class="fas fa-plus faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        Yes, our system allows you to easily generate and export comprehensive reports in CSV and PDF formats, making it simple to share insights with your team or stakeholders.
                    </div>
                </div>

                <div class="faq-item reveal stagger-3">
                    <div class="faq-question">
                        Is my data secure?
                        <i class="fas fa-plus faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        We take security very seriously. All data is encrypted in transit and at rest. We employ role-based access control so only authorized personnel can access sensitive complaint information.
                    </div>
                </div>

                <div class="faq-item reveal stagger-4">
                    <div class="faq-question">
                        Can multiple staff members collaborate on a single issue?
                        <i class="fas fa-plus faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        Absolutely. The system supports team collaboration, allowing multiple staff members to leave internal notes, update statuses, and work together to resolve complex complaints efficiently.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         CTA
         ======================================== -->
    <section class="cta-section">
        <div class="cta-bg">
            <img src="{{ asset('images/landing/cta-bg.png') }}" alt="" loading="lazy">
        </div>

        <div class="container-xl">
            <div class="cta-content">
                <div class="section-label reveal" style="color: var(--c-teal-light);">Get Started</div>
                <h2 class="section-title reveal">Ready to Transform Your<br><span class="gradient-text">Complaint Management?</span></h2>
                <p class="section-subtitle reveal">Join organizations that trust CSRTS to handle complaints efficiently, transparently, and at scale.</p>

                <div class="cta-actions reveal">
                    @auth
                        @if(Auth::user() && Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-rocket"></i> Access Dashboard
                            </a>
                        @elseif(Auth::user() && Auth::user()->isStaff())
                            <a href="{{ route('staff.dashboard') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-rocket"></i> Access Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-rocket"></i> Access Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus"></i> Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-white btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Sign In
                        </a>
                    @endauth
                </div>

                <div class="cta-note reveal">
                    <i class="fas fa-shield-alt"></i> No credit card required · Free forever for small teams
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         FOOTER
         ======================================== -->
    <footer class="footer">
        <div class="container-xl">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">
                        <div class="footer-brand-icon"><i class="fas fa-shield-alt"></i></div>
                        <span>CSRTS</span>
                    </div>
                    <p class="footer-description">Complaint & Service Request Tracking System. A modern, open-source solution for efficient complaint management and resolution.</p>
                    <div class="footer-socials">
                        <a href="#" class="footer-social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="footer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="footer-social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="footer-social-link" aria-label="GitHub"><i class="fab fa-github"></i></a>
                    </div>
                </div>

                <div>
                    <div class="footer-col-title">Product</div>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#stats">Statistics</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <div class="footer-col-title">Resources</div>
                    <ul class="footer-links">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API Reference</a></li>
                        <li><a href="#">Release Notes</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>

                <div>
                    <div class="footer-col-title">Contact</div>
                    <ul class="footer-links">
                        <li><a href="mailto:hamzaiqbalrajpoot35@gmail.com"><i class="fas fa-envelope" style="margin-right: 6px; font-size: 0.8rem;"></i> Email Us</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt" style="margin-right: 6px; font-size: 0.8rem;"></i> Location</a></li>
                        <li><a href="#"><i class="fas fa-phone" style="margin-right: 6px; font-size: 0.8rem;"></i> Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-copyright">&copy; {{ date('Y') }} Complaint & Service Request Tracking System. All rights reserved.</div>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========================================
         SCRIPTS
         ======================================== -->
    <script>
        // ---- Navbar scroll effect ----
        const navbar = document.getElementById('mainNavbar');
        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;
            if (currentScroll > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            lastScroll = currentScroll;
        }, { passive: true });

        // ---- Scroll reveal (Intersection Observer) ----
        const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));

        // ---- Animated counters ----
        const counters = document.querySelectorAll('.counter');
        let countersAnimated = false;

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !countersAnimated) {
                    countersAnimated = true;
                    counters.forEach(counter => {
                        const target = +counter.getAttribute('data-target');
                        const duration = 2000;
                        const startTime = performance.now();

                        function updateCounter(currentTime) {
                            const elapsed = currentTime - startTime;
                            const progress = Math.min(elapsed / duration, 1);
                            // Ease-out cubic
                            const eased = 1 - Math.pow(1 - progress, 3);
                            counter.textContent = Math.floor(eased * target);

                            if (progress < 1) {
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target;
                            }
                        }

                        requestAnimationFrame(updateCounter);
                    });
                }
            });
        }, { threshold: 0.3 });

        const statsSection = document.getElementById('stats');
        if (statsSection) counterObserver.observe(statsSection);

        // ---- Smooth scroll for anchor links ----
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offset = 80;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });

        // ---- Mobile menu toggle ----
        const mobileToggle = document.getElementById('mobileToggle');
        const navLinks = document.querySelector('.navbar-links');
        const navActions = document.querySelector('.navbar-actions');

        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                const isOpen = navLinks.style.display === 'flex';
                navLinks.style.display = isOpen ? 'none' : 'flex';
                navLinks.style.flexDirection = 'column';
                navLinks.style.position = 'absolute';
                navLinks.style.top = '100%';
                navLinks.style.left = '0';
                navLinks.style.right = '0';
                navLinks.style.background = 'rgba(15,23,42,0.95)';
                navLinks.style.backdropFilter = 'blur(20px)';
                navLinks.style.padding = '20px 24px';
                navLinks.style.gap = '16px';
                navLinks.style.borderRadius = '0 0 16px 16px';
                mobileToggle.innerHTML = isOpen ? '<i class="fas fa-bars"></i>' : '<i class="fas fa-times"></i>';
            });
        }
        // ---- FAQ Toggle ----
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentElement;
                const isActive = item.classList.contains('active');
                
                // Close all other FAQs
                document.querySelectorAll('.faq-item').forEach(faq => {
                    faq.classList.remove('active');
                });
                
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });

    </script>
    
    <!-- ========================================
         3D TILT & INTERACTIVE BACKGROUND
         ======================================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    
    <script>
        // Custom Cursor Logic
        const cursorDot = document.getElementById("cursor-dot");
        const cursorOutline = document.getElementById("cursor-outline");
        let cursorX = 0, cursorY = 0;
        let outlineX = 0, outlineY = 0;

        window.addEventListener("mousemove", (e) => {
            cursorX = e.clientX;
            cursorY = e.clientY;
            if (cursorDot) {
                cursorDot.style.left = cursorX + "px";
                cursorDot.style.top = cursorY + "px";
            }
        });

        function animateCursor() {
            let distX = cursorX - outlineX;
            let distY = cursorY - outlineY;
            
            outlineX = outlineX + (distX * 0.15);
            outlineY = outlineY + (distY * 0.15);
            
            if (cursorOutline) {
                cursorOutline.style.left = outlineX + "px";
                cursorOutline.style.top = outlineY + "px";
            }
            
            requestAnimationFrame(animateCursor);
        }
        animateCursor();

        document.querySelectorAll("a, button, input, textarea, select, .cursor-pointer, .bento-item, .feature-card, .faq-question").forEach(el => {
            el.addEventListener("mouseenter", () => {
                if (cursorOutline) cursorOutline.classList.add("hovering");
            });
            el.addEventListener("mouseleave", () => {
                if (cursorOutline) cursorOutline.classList.remove("hovering");
            });
        });

        // Initialize Vanilla Tilt
        if (typeof VanillaTilt !== 'undefined') {
            VanillaTilt.init(document.querySelectorAll(".bento-item, .feature-card, .stat-card"), {
                max: 5,
                speed: 400,
                glare: true,
                "max-glare": 0.15,
            });
            VanillaTilt.init(document.querySelectorAll(".showcase-image"), {
                max: 8,
                speed: 400,
                glare: false,
            });
        }

        // Initialize tsParticles
        if (typeof tsParticles !== 'undefined') {
            tsParticles.load("tsparticles", {
                fpsLimit: 60,
                interactivity: {
                    events: {
                        onHover: { enable: true, mode: "grab" },
                        resize: true,
                    },
                    modes: {
                        grab: { distance: 200, links: { opacity: 0.5 } }
                    },
                },
                particles: {
                    color: { value: ["#0d9488", "#059669"] },
                    links: {
                        color: "#0d9488",
                        distance: 150,
                        enable: true,
                        opacity: 0.2,
                        width: 1,
                    },
                    move: {
                        direction: "none",
                        enable: true,
                        outModes: { default: "bounce" },
                        random: false,
                        speed: 1,
                        straight: false,
                    },
                    number: { density: { enable: true, area: 800 }, value: 40 },
                    opacity: { value: 0.3 },
                    shape: { type: "circle" },
                    size: { value: { min: 1, max: 3 } },
                },
                detectRetina: true,
            });
        }
    </script>
</body>
</html>
