<?php
// AgriSeed AI — Landing Page (UI refresh; logic unchanged)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriSeed AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --bg: #f6f9f6;
        --surface: #ffffff;
        --ink: #0f1f17;
        --ink-soft: #4a5b52;
        --muted: #7a8a82;
        --line: #e6ede7;
        --brand: #1f7a4d;
        --brand-600: #176b41;
        --brand-700: #125936;
        --brand-50: #e8f5ee;
        --leaf: #3aa66a;
        --accent: #e8a13a;
        --accent-600: #d68f2a;
        --accent-50: #fdf3e2;
        --sky: #2f7bd1;
        --sky-50: #e8f1fb;
        --shadow-sm: 0 1px 2px rgba(15, 31, 23, .06), 0 1px 3px rgba(15, 31, 23, .04);
        --shadow-md: 0 4px 16px rgba(15, 31, 23, .08);
        --shadow-lg: 0 18px 50px -12px rgba(15, 31, 23, .22);
        --radius: 16px;
        --radius-lg: 22px;
        --maxw: 1180px;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    html {
        scroll-behavior: smooth
    }

    body {
        font-family: 'Inter', system-ui, sans-serif;
        background: var(--bg);
        color: var(--ink);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    h1,
    h2,
    h3,
    h4 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1.2;
        letter-spacing: -.02em;
        color: var(--ink)
    }

    a {
        color: inherit;
        text-decoration: none
    }

    .container {
        max-width: var(--maxw);
        margin: 0 auto;
        padding: 0 24px;
        width: 100%
    }

    /* ===== NAV ===== */
    .topnav {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(255, 255, 255, .82);
        backdrop-filter: saturate(180%) blur(14px);
        -webkit-backdrop-filter: saturate(180%) blur(14px);
        border-bottom: 1px solid var(--line);
    }

    .topnav .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans';
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: -.03em
    }

    .brand-mark {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: linear-gradient(135deg, var(--brand), var(--leaf));
        display: grid;
        place-items: center;
        color: #fff;
        box-shadow: 0 6px 16px -4px rgba(31, 122, 77, .5);
    }

    .brand-mark svg {
        width: 22px;
        height: 22px
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none
    }

    .nav-links a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: .92rem;
        font-weight: 500;
        color: var(--ink-soft);
        transition: background .18s, color .18s;
    }

    .nav-links a:hover {
        background: var(--brand-50);
        color: var(--brand-700)
    }

    .nav-links a svg {
        width: 17px;
        height: 17px
    }

    .nav-cta {
        background: var(--brand);
        color: #fff !important;
        padding: 10px 18px !important;
        border-radius: 11px;
        font-weight: 600 !important;
        box-shadow: 0 6px 16px -4px rgba(31, 122, 77, .45);
        transition: transform .18s, background .18s;
    }

    .nav-cta:hover {
        background: var(--brand-600);
        transform: translateY(-1px)
    }

    .nav-toggle {
        display: none;
        background: none;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 1.1rem;
        cursor: pointer;
        color: var(--ink)
    }

    /* ===== HERO ===== */
    .hero {
        position: relative;
        overflow: hidden;
        padding: 90px 0 80px
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        background:
            radial-gradient(900px 500px at 12% -5%, rgba(58, 166, 106, .18), transparent 60%),
            radial-gradient(800px 500px at 95% 10%, rgba(47, 123, 209, .12), transparent 55%),
            radial-gradient(700px 400px at 70% 110%, rgba(232, 161, 58, .10), transparent 60%);
    }

    .hero .container {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1.05fr .95fr;
        gap: 60px;
        align-items: center
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1px solid var(--line);
        color: var(--brand-700);
        font-weight: 600;
        font-size: .82rem;
        padding: 7px 14px;
        border-radius: 999px;
        margin-bottom: 22px;
        box-shadow: var(--shadow-sm);
    }

    .eyebrow .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--leaf);
        box-shadow: 0 0 0 4px rgba(58, 166, 106, .18)
    }

    .hero h1 {
        font-size: clamp(2.6rem, 5.2vw, 4.1rem);
        font-weight: 800;
        background: linear-gradient(120deg, var(--ink) 30%, var(--brand) 120%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 18px;
    }

    .hero .lead {
        font-size: 1.18rem;
        color: var(--ink-soft);
        max-width: 540px;
        margin-bottom: 30px
    }

    .hero-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 38px
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 26px;
        border-radius: 13px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: transform .18s, box-shadow .18s, background .18s;
        border: none;
    }

    .btn svg {
        width: 19px;
        height: 19px
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--brand), var(--brand-600));
        color: #fff;
        box-shadow: 0 12px 26px -8px rgba(31, 122, 77, .6)
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px -10px rgba(31, 122, 77, .7)
    }

    .btn-secondary {
        background: var(--surface);
        color: var(--ink);
        border: 1.5px solid var(--line);
        box-shadow: var(--shadow-sm)
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        border-color: var(--brand);
        color: var(--brand-700);
        box-shadow: var(--shadow-md)
    }

    .feature-list {
        list-style: none;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px 28px;
        max-width: 520px
    }

    .feature-list li {
        display: flex;
        align-items: center;
        gap: 11px;
        font-size: .96rem;
        color: var(--ink-soft);
        font-weight: 500
    }

    .feature-list .ico {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        background: var(--brand-50);
        color: var(--brand-700);
    }

    .feature-list .ico svg {
        width: 17px;
        height: 17px
    }

    /* hero visual */
    .hero-visual {
        position: relative
    }

    .hero-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 26px;
        box-shadow: var(--shadow-lg);
    }

    .hero-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px
    }

    .hero-card-head .tag {
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .08em
    }

    .live {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: .8rem;
        font-weight: 600;
        color: var(--brand)
    }

    .live::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--leaf);
        animation: pulse 1.6s infinite
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(58, 166, 106, .5)
        }

        50% {
            box-shadow: 0 0 0 7px rgba(58, 166, 106, 0)
        }
    }

    .metrics {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px
    }

    .metric {
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: 13px;
        padding: 16px
    }

    .metric .v {
        font-family: 'Plus Jakarta Sans';
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--brand-700)
    }

    .metric .l {
        font-size: .78rem;
        color: var(--muted);
        margin-top: 2px
    }

    .hero-fields {
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px
    }

    .field-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        background: var(--bg);
        border: 1px solid var(--line)
    }

    .field-row .ico {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        flex: 0 0 auto
    }

    .field-row .ico svg {
        width: 18px;
        height: 18px
    }

    .field-row .t {
        font-size: .9rem;
        font-weight: 600
    }

    .field-row .s {
        font-size: .78rem;
        color: var(--muted)
    }

    .float-chip {
        position: absolute;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 12px 16px;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .85rem;
        font-weight: 600;
    }

    .float-chip .ico {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        display: grid;
        place-items: center
    }

    .float-chip .ico svg {
        width: 16px;
        height: 16px
    }

    .chip-1 {
        top: -22px;
        left: -26px;
        animation: float 5s ease-in-out infinite
    }

    .chip-2 {
        bottom: -20px;
        right: -20px;
        animation: float 5s ease-in-out infinite .8s
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0)
        }

        50% {
            transform: translateY(-9px)
        }
    }

    /* ===== CARDS SECTION ===== */
    .cards-section {
        padding: 30px 0 80px
    }

    .section-head {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 44px
    }

    .section-head .kicker {
        color: var(--brand);
        font-weight: 700;
        font-size: .85rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 10px
    }

    .section-head h2 {
        font-size: clamp(1.8rem, 3.5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 12px
    }

    .section-head p {
        color: var(--ink-soft);
        font-size: 1.08rem
    }

    .grid {
        display: grid;
        gap: 22px
    }

    .grid-3 {
        grid-template-columns: repeat(3, 1fr)
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s, border-color .2s;
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 0;
        background: linear-gradient(var(--brand), var(--leaf));
        transition: height .25s
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: transparent
    }

    .card:hover::before {
        height: 100%
    }

    .card-ico {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        margin-bottom: 18px;
        background: var(--brand-50);
        color: var(--brand-700);
    }

    .card-ico svg {
        width: 26px;
        height: 26px
    }

    .card:nth-child(2) .card-ico {
        background: var(--accent-50);
        color: var(--accent-600)
    }

    .card:nth-child(3) .card-ico {
        background: var(--sky-50);
        color: var(--sky)
    }

    .card h3 {
        font-size: 1.28rem;
        font-weight: 700;
        margin-bottom: 10px
    }

    .card-muted {
        color: var(--ink-soft);
        font-size: .98rem
    }

    /* ===== FOOTER ===== */
    .site-footer {
        border-top: 1px solid var(--line);
        background: var(--surface);
        padding: 34px 0;
        margin-top: 20px
    }

    .site-footer .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px
    }

    .site-footer .foot-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: var(--ink)
    }

    .site-footer .foot-brand svg {
        width: 18px;
        height: 18px;
        color: var(--brand)
    }

    .site-footer small {
        color: var(--muted)
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width:900px) {
        .hero .container {
            grid-template-columns: 1fr;
            gap: 48px
        }

        .hero-visual {
            max-width: 460px;
            margin: 0 auto;
            width: 100%
        }

        .grid-3 {
            grid-template-columns: 1fr
        }
    }

    @media (max-width:760px) {
        .nav-toggle {
            display: block
        }

        .nav-links {
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            flex-direction: column;
            align-items: stretch;
            gap: 2px;
            background: var(--surface);
            border-bottom: 1px solid var(--line);
            padding: 12px 24px 18px;
            box-shadow: var(--shadow-md);
            display: none;
        }

        .nav-links.open {
            display: flex
        }

        .nav-links a {
            padding: 13px 14px;
            font-size: 1rem
        }

        .nav-cta {
            margin-top: 6px;
            text-align: center;
            justify-content: center
        }

        .hero {
            padding: 60px 0 60px
        }

        .feature-list {
            grid-template-columns: 1fr
        }

        .float-chip {
            display: none
        }
    }
    </style>
</head>

<body>

    <nav class="topnav">
        <div class="container">
            <a href="index.php" class="brand">
                <span class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M11 20A7 7 0 0 1 4 13c0-2 .5-5 4-7 2 2 4 4 4 7" />
                        <path d="M20 8c-3 0-5 1-6 3" />
                        <path d="M11 20c0-5 1-8 6-12 1 3 1 7-2 9" />
                    </svg>
                </span>
                AgriSeed AI
            </a>
            <button class="nav-toggle" aria-label="Toggle navigation">☰</button>
            <ul class="nav-links">
                <li><a href="index.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg> Home</a></li>
                <li><a href="assistant.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="7" width="16" height="12" rx="2" />
                            <circle cx="9" cy="13" r="1" />
                            <circle cx="15" cy="13" r="1" />
                            <path d="M12 7V4M9 4h6" />
                        </svg> AI Assistant</a></li>
                <li><a href="crop-advisor.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v6" />
                            <path d="M5.5 8 12 14" />
                            <path d="M18.5 8 12 14" />
                            <path d="M12 22V14" />
                        </svg> Crop Advisor</a></li>
                <li><a href="plant-doctor.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                            <path d="M5 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                            <path d="M12 22V12" />
                        </svg> Plant Doctor</a></li>
                <li><a href="irrigation.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                        </svg> Irrigation</a></li>
                <li><a href="dashboard.php" class="nav-cta"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="9" rx="1" />
                            <rect x="14" y="3" width="7" height="5" rx="1" />
                            <rect x="14" y="12" width="7" height="9" rx="1" />
                            <rect x="3" y="16" width="7" height="5" rx="1" />
                        </svg> Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-copy">
                <span class="eyebrow"><span class="dot"></span> AgriSeed Rover Project</span>
                <h1>AgriSeed AI</h1>
                <p class="lead">Intelligent agriculture. Better decisions. Get practical farming guidance powered by AI
                    — in English or Kinyarwanda.</p>
                <div class="hero-actions">
                    <a href="assistant.php" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 3h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9l-5 4V5a2 2 0 0 1 2-2z" />
                        </svg>
                        Ask AgriSeed AI
                    </a>
                    <a href="plant-doctor.php" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                            <path d="M5 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                            <path d="M12 22V12" />
                        </svg>
                        Analyze My Plant
                    </a>
                </div>
                <ul class="feature-list">
                    <li><span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="7" width="16" height="12" rx="2" />
                                <circle cx="9" cy="13" r="1" />
                                <circle cx="15" cy="13" r="1" />
                            </svg></span> AI Agriculture Assistant</li>
                    <li><span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v6" />
                                <path d="M5.5 8 12 14" />
                                <path d="M18.5 8 12 14" />
                            </svg></span> Crop Recommendation</li>
                    <li><span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                                <path d="M12 22V12" />
                            </svg></span> Plant Health Analysis</li>
                    <li><span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                            </svg></span> Smart Irrigation</li>
                    <li><span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0" />
                                <circle cx="12" cy="10" r="3" />
                            </svg></span> Location-Based Advice</li>
                    <li><span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20" />
                            </svg></span> Kinyarwanda + English</li>
                </ul>
            </div>

            <div class="hero-visual">
                <div class="hero-card">
                    <div class="hero-card-head">
                        <span class="tag">Field Overview</span>
                        <span class="live">Live sync</span>
                    </div>
                    <div class="metrics">
                        <div class="metric">
                            <div class="v">87%</div>
                            <div class="l">Soil health</div>
                        </div>
                        <div class="metric">
                            <div class="v">24°C</div>
                            <div class="l">Field temp</div>
                        </div>
                        <div class="metric">
                            <div class="v">3.2k</div>
                            <div class="l">Advisories</div>
                        </div>
                    </div>
                    <div class="hero-fields">
                        <div class="field-row">
                            <span class="ico" style="background:var(--brand-50);color:var(--brand-700)"><svg
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                                </svg></span>
                            <div>
                                <div class="t">Irrigation scheduled</div>
                                <div class="s">Sector B · 06:00 AM</div>
                            </div>
                        </div>
                        <div class="field-row">
                            <span class="ico" style="background:var(--accent-50);color:var(--accent-600)"><svg
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="4" />
                                    <path
                                        d="M12 2v2M12 20v2M2 12h2M20 12h2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                                </svg></span>
                            <div>
                                <div class="t">Crop recommendation ready</div>
                                <div class="s">Maize · Beans this season</div>
                            </div>
                        </div>
                        <div class="field-row">
                            <span class="ico" style="background:var(--sky-50);color:var(--sky)"><svg viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M19 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                                    <path d="M12 22V12" />
                                </svg></span>
                            <div>
                                <div class="t">Plant scan completed</div>
                                <div class="s">No disease detected</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-chip chip-1">
                    <span class="ico" style="background:var(--brand-50);color:var(--brand-700)"><svg viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg></span>
                    Guidance ready
                </div>
                <div class="float-chip chip-2">
                    <span class="ico" style="background:var(--sky-50);color:var(--sky)"><svg viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 2a10 10 0 1 0 10 10" />
                            <path d="M22 2 12 12" />
                        </svg></span>
                    Bilingual support
                </div>
            </div>
        </div>
    </header>

    <section class="cards-section">
        <div class="container">
            <div class="section-head">
                <div class="kicker">Why AgriSeed AI</div>
                <h2>Built for the realities of farming</h2>
                <p>Clear, dependable agricultural intelligence — designed for the field, not the lab.</p>
            </div>
            <div class="grid grid-3">
                <div class="card">
                    <div class="card-ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18" />
                            <path d="M5 21V7l8-4v18" />
                            <path d="M19 21V11l-6-4" />
                        </svg>
                    </div>
                    <h3>Built for real farms</h3>
                    <p class="card-muted">Practical answers to everyday questions — pests, soil, watering, and what to
                        plant this season — without unnecessary jargon.</p>
                </div>
                <div class="card">
                    <div class="card-ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4M12 16h.01" />
                        </svg>
                    </div>
                    <h3>Honest about uncertainty</h3>
                    <p class="card-muted">AgriSeed AI tells you when it isn't sure, and never claims a lab-certain
                        diagnosis from a photo alone.</p>
                </div>
                <div class="card">
                    <div class="card-ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="10" rx="2" />
                            <circle cx="12" cy="16" r="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                            <circle cx="12" cy="5" r="1" />
                        </svg>
                    </div>
                    <h3>Part of AgriSeed Rover</h3>
                    <p class="card-muted">A companion to the AgriSeed autonomous planting and watering rover, focused
                        purely on agricultural intelligence for the farmer.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <span class="foot-brand">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M11 20A7 7 0 0 1 4 13c0-2 .5-5 4-7 2 2 4 4 4 7" />
                    <path d="M20 8c-3 0-5 1-6 3" />
                </svg>
                AgriSeed AI
            </span>
            <small>Part of the AgriSeed Rover project</small>
        </div>
    </footer>

    <script>
    (function() {
        var t = document.querySelector('.nav-toggle'),
            l = document.querySelector('.nav-links');
        if (t && l) {
            t.addEventListener('click', function() {
                l.classList.toggle('open');
            });
        }
    })();
    </script>
</body>

</html>