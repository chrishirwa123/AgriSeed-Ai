<?php
// AgriSeed AI — Dashboard (Updated to match index.php styling)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
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
        padding: 0;
    }

    html {
        scroll-behavior: smooth;
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
        color: var(--ink);
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    .container {
        max-width: var(--maxw);
        margin: 0 auto;
        padding: 0 24px;
        width: 100%;
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
        height: 70px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans';
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: -.03em;
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
        height: 22px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
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
        color: var(--brand-700);
    }

    .nav-links a svg {
        width: 17px;
        height: 17px;
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
        transform: translateY(-1px);
    }

    .nav-toggle {
        display: none;
        background: none;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 1.1rem;
        cursor: pointer;
        color: var(--ink);
    }

    /* ===== DASHBOARD SECTION ===== */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .dash-greeting h2 {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .dash-greeting p {
        color: var(--ink-soft);
        font-size: 1rem;
    }

    .grid {
        display: grid;
        gap: 22px;
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .grid-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s, border-color .2s;
        position: relative;
    }

    .card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card h3 svg {
        width: 20px;
        height: 20px;
        color: var(--brand);
    }

    .card-muted {
        color: var(--ink-soft);
        font-size: .95rem;
    }

    /* Action Grid Cards */
    .action-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin: 28px 0;
    }

    .action-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s, border-color .2s;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 0;
        background: linear-gradient(var(--brand), var(--leaf));
        transition: height .25s;
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }

    .action-card:hover::before {
        height: 100%;
    }

    .action-card .ico-box {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: var(--brand-50);
        color: var(--brand-700);
        margin-bottom: 4px;
    }

    .action-card .ico-box svg {
        width: 24px;
        height: 24px;
    }

    .action-card:nth-child(2) .ico-box {
        background: var(--accent-50);
        color: var(--accent-600);
    }

    .action-card:nth-child(3) .ico-box {
        background: #fde8e8;
        color: #e02424;
    }

    .action-card:nth-child(4) .ico-box {
        background: var(--sky-50);
        color: var(--sky);
    }

    .action-card .title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--ink);
    }

    .action-card .desc {
        font-size: .88rem;
        color: var(--ink-soft);
        line-height: 1.4;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 11px;
        font-weight: 600;
        font-size: .9rem;
        cursor: pointer;
        transition: transform .18s, box-shadow .18s, background .18s;
        border: none;
    }

    .btn-sm {
        padding: 8px 14px;
        font-size: .84rem;
        border-radius: 9px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--brand), var(--brand-600));
        color: #fff;
        box-shadow: 0 6px 16px -4px rgba(31, 122, 77, .45);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        background: var(--brand-600);
    }

    .btn-outline {
        background: var(--surface);
        color: var(--ink-soft);
        border: 1px solid var(--line);
    }

    .btn-outline:hover {
        background: var(--brand-50);
        color: var(--brand-700);
        border-color: var(--brand-50);
    }

    /* Location Widget Custom Styles */
    .location-widget {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-top: 10px;
    }

    .location-current {
        font-weight: 600;
        font-size: 1.05rem;
        color: var(--ink);
    }

    .field-hint {
        font-size: .82rem;
        color: var(--muted);
        margin-top: 8px;
    }

    .manual-location-form {
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .field label {
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink-soft);
    }

    .field input {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid var(--line);
        background: var(--bg);
        font-family: inherit;
        font-size: .9rem;
    }

    .field input:focus {
        outline: none;
        border-color: var(--brand);
    }

    /* ===== FOOTER ===== */
    .site-footer {
        border-top: 1px solid var(--line);
        background: var(--surface);
        padding: 34px 0;
        margin-top: 40px;
    }

    .site-footer .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .site-footer .foot-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: var(--ink);
    }

    .site-footer .foot-brand svg {
        width: 18px;
        height: 18px;
        color: var(--brand);
    }

    .site-footer small {
        color: var(--muted);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width:992px) {
        .action-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width:760px) {
        .nav-toggle {
            display: block;
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
            display: flex;
        }

        .nav-links a {
            padding: 13px 14px;
            font-size: 1rem;
        }

        .nav-cta {
            margin-top: 6px;
            text-align: center;
            justify-content: center;
        }

        .grid-2,
        .grid-3 {
            grid-template-columns: 1fr;
        }

        .action-grid {
            grid-template-columns: 1fr;
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

    <main class="container" style="padding-top: 40px; padding-bottom: 60px;">

        <div class="dash-header">
            <div class="dash-greeting">
                <h2 id="greetingText">Good morning!</h2>
                <p class="card-muted">What would you like help with today?</p>
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button class="btn btn-outline btn-sm" data-lang-option="en">🇬🇧 English</button>
                <button class="btn btn-outline btn-sm" data-lang-option="rw">🇷🇼 Kinyarwanda</button>
            </div>
        </div>

        <div class="grid grid-2">
            <div class="card" id="locationWidget">
                <h3>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0" />
                        <circle cx="12" cy="10" r="3" />
                    </svg> Location
                </h3>
                <div class="location-widget">
                    <div class="location-current">
                        <span id="locationLabel">Not set</span>
                    </div>
                    <div style="display:flex; gap:0.5rem; flex-wrap: wrap;">
                        <button class="btn btn-primary btn-sm" id="useLocationBtn">Use My Location</button>
                        <button class="btn btn-outline btn-sm" id="manualLocationToggle" type="button">Enter
                            Manually</button>
                    </div>
                </div>
                <p class="field-hint" id="locationStatus"></p>
                <form class="manual-location-form" id="manualLocationForm" style="display:none;">
                    <div class="grid grid-3">
                        <div class="field"><label>City/Town</label><input type="text" name="manualCity"></div>
                        <div class="field"><label>District</label><input type="text" name="manualDistrict"></div>
                        <div class="field"><label>Country</label><input type="text" name="manualCountry" value="Rwanda">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit" style="margin-top:8px;">Save Location</button>
                </form>
            </div>

            <div class="card" id="weatherCard">
                <h3>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4" />
                        <path
                            d="M12 2v2M12 20v2M2 12h2M20 12h2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                    </svg> Weather
                </h3>
                <p class="card-muted">Set your location to see current weather.</p>
            </div>
        </div>

        <div class="action-grid">
            <a href="assistant.php" class="action-card">
                <div class="ico-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="4" y="7" width="16" height="12" rx="2" />
                        <circle cx="9" cy="13" r="1" />
                        <circle cx="15" cy="13" r="1" />
                        <path d="M12 7V4M9 4h6" />
                    </svg>
                </div>
                <span class="title">Ask Agriculture AI</span>
                <span class="desc">Chat about pests, soil, watering, and practical field decisions</span>
            </a>
            <a href="crop-advisor.php" class="action-card">
                <div class="ico-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 2v6" />
                        <path d="M5.5 8 12 14" />
                        <path d="M18.5 8 12 14" />
                        <path d="M12 22V14" />
                    </svg>
                </div>
                <span class="title">Crop Advisor</span>
                <span class="desc">Get tailored crop recommendations for your local soil conditions</span>
            </a>
            <a href="plant-doctor.php" class="action-card">
                <div class="ico-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                        <path d="M5 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                        <path d="M12 22V12" />
                    </svg>
                </div>
                <span class="title">Plant Doctor</span>
                <span class="desc">Scan plant symptoms and photos to check crop health</span>
            </a>
            <a href="irrigation.php" class="action-card">
                <div class="ico-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                    </svg>
                </div>
                <span class="title">Irrigation Advisor</span>
                <span class="desc">Smart schedules for optimal field watering</span>
            </a>
        </div>

        <div class="card">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg> Recent Activity
            </h3>
            <p class="card-muted" id="recentActivity">Nothing yet — try the Crop Advisor or Plant Doctor above.</p>
        </div>

    </main>

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

    <script src="js/app.js"></script>
    <script src="js/location.js"></script>
    <script>
    (function() {
        // Toggle Navigation Menu
        var t = document.querySelector('.nav-toggle'),
            l = document.querySelector('.nav-links');
        if (t && l) {
            t.addEventListener('click', function() {
                l.classList.toggle('open');
            });
        }

        // Toggle Manual Location Form Visibility
        var btn = document.getElementById('manualLocationToggle'),
            form = document.getElementById('manualLocationForm');
        if (btn && form) {
            btn.addEventListener('click', function() {
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'flex' :
                    'none';
            });
        }

        // Greeting initialization
        if (window.AgriSeed && typeof window.AgriSeed.greeting === 'function') {
            document.getElementById('greetingText').textContent = AgriSeed.greeting();
        }
    })();
    </script>
</body>

</html>