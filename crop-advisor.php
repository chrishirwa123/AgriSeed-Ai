<?php
// AgriSeed AI — Crop Advisor Page (UI refresh; logic unchanged)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Advisor — AgriSeed AI</title>
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
        min-height: 100vh;
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
        height: 70px;
        position: relative
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

    .nav-links a.active {
        background: var(--brand-50);
        color: var(--brand-700);
        font-weight: 600
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

    .nav-cta.active {
        background: var(--brand-600)
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

    /* ===== PAGE ===== */
    main.container {
        padding: 32px 24px 56px;
        max-width: 860px
    }

    .page-head {
        margin-bottom: 26px;
        display: flex;
        align-items: center;
        gap: 16px
    }

    .page-head .ico {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        flex: 0 0 auto;
        background: linear-gradient(135deg, var(--brand), var(--leaf));
        display: grid;
        place-items: center;
        color: #fff;
        box-shadow: 0 12px 26px -8px rgba(31, 122, 77, .55);
    }

    .page-head .ico svg {
        width: 30px;
        height: 30px
    }

    .page-head h1 {
        font-size: 1.75rem;
        font-weight: 800
    }

    .page-head p {
        color: var(--ink-soft);
        font-size: 1rem;
        margin-top: 2px
    }

    /* ===== CARD ===== */
    .card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-md);
    }

    /* ===== FORM ===== */
    .grid {
        display: grid;
        gap: 20px
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr)
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 7px
    }

    .field label {
        font-size: .85rem;
        font-weight: 600;
        color: var(--ink-soft);
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .field label svg {
        width: 15px;
        height: 15px;
        color: var(--brand)
    }

    .field input,
    .field select,
    .field textarea {
        font-family: inherit;
        font-size: .96rem;
        color: var(--ink);
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 12px 14px;
        transition: border-color .18s, background .18s, box-shadow .18s;
        width: 100%;
    }

    .field input::placeholder,
    .field textarea::placeholder {
        color: var(--muted)
    }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        outline: none;
        border-color: var(--brand);
        background: var(--surface);
        box-shadow: 0 0 0 3px rgba(31, 122, 77, .12);
    }

    .field select {
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%237a8a82' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
    }

    .field-full {
        grid-column: 1 / -1
    }

    .form-actions {
        margin-top: 26px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 13px 24px;
        border-radius: 13px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: transform .18s, box-shadow .18s, background .18s;
        border: none;
        font-family: inherit;
    }

    .btn svg {
        width: 19px;
        height: 19px
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--brand), var(--brand-600));
        color: #fff;
        box-shadow: 0 10px 24px -8px rgba(31, 122, 77, .6)
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 30px -10px rgba(31, 122, 77, .7)
    }

    /* ===== RESULT ===== */
    #cropResult {
        margin-top: 22px
    }

    /* ===== RESPONSIVE ===== */
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

        .grid-2 {
            grid-template-columns: 1fr
        }

        main.container {
            padding: 24px 16px 40px
        }

        .card {
            padding: 22px
        }

        .page-head .ico {
            width: 48px;
            height: 48px
        }

        .page-head h1 {
            font-size: 1.4rem
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
                <li><a href="crop-advisor.php" class="active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
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

    <main class="container">
        <div class="page-head">
            <span class="ico">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 2v6" />
                    <path d="M5.5 8 12 14" />
                    <path d="M18.5 8 12 14" />
                    <path d="M12 22V14" />
                </svg>
            </span>
            <div>
                <h1>Crop Advisor</h1>
                <p>Tell us about your field and conditions — we'll suggest crops that fit, and explain why.</p>
            </div>
        </div>

        <form id="cropForm" class="card">
            <div class="grid grid-2">
                <div class="field">
                    <label for="cropLocation"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0" />
                            <circle cx="12" cy="10" r="3" />
                        </svg> Location</label>
                    <input type="text" id="cropLocation" name="location" placeholder="e.g. Nyagatare, Rwanda">
                </div>
                <div class="field">
                    <label for="cropSoil"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 18c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2" />
                            <path d="M3 12c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2" />
                        </svg> Soil type</label>
                    <select id="cropSoil" name="soilType">
                        <option value="">Not sure</option>
                        <option>Clay</option>
                        <option>Sandy</option>
                        <option>Loam</option>
                        <option>Silty</option>
                        <option>Rocky</option>
                    </select>
                </div>
                <div class="field">
                    <label for="cropTemp"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0z" />
                        </svg> Typical temperature (°C)</label>
                    <input type="number" id="cropTemp" name="temperature" placeholder="e.g. 24">
                </div>
                <div class="field">
                    <label for="cropRain"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M8 19v1M8 14v1M16 19v1M16 14v1M12 21v1M12 16v1M20 16.58A5 5 0 0 0 18 7h-1.26A8 8 0 1 0 4 15.25" />
                        </svg> Rainfall</label>
                    <select id="cropRain" name="rainfall">
                        <option value="">Not sure</option>
                        <option>Low</option>
                        <option>Moderate</option>
                        <option>High</option>
                    </select>
                </div>
                <div class="field">
                    <label for="cropSeason"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg> Season</label>
                    <select id="cropSeason" name="season">
                        <option value="">Not sure</option>
                        <option>Season A (Sep–Feb)</option>
                        <option>Season B (Feb–Jun)</option>
                        <option>Season C (Jun–Sep, marshland)</option>
                        <option>Dry season</option>
                        <option>Wet season</option>
                    </select>
                </div>
                <div class="field">
                    <label for="cropWater"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                        </svg> Water availability</label>
                    <select id="cropWater" name="waterAvailability">
                        <option value="">Not sure</option>
                        <option>Rain-fed only</option>
                        <option>Irrigation available</option>
                        <option>Limited water</option>
                    </select>
                </div>
                <div class="field">
                    <label for="cropFarmSize"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3h18v18H3z" />
                            <path d="M3 9h18M9 21V9" />
                        </svg> Farm size (optional)</label>
                    <input type="text" id="cropFarmSize" name="farmSize" placeholder="e.g. 0.5 hectares">
                </div>
                <div class="field">
                    <label for="cropPrevious"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v6" />
                            <path d="M5.5 8 12 14" />
                            <path d="M18.5 8 12 14" />
                        </svg> Previous crop (optional)</label>
                    <input type="text" id="cropPrevious" name="previousCrop" placeholder="e.g. Beans">
                </div>
                <div class="field field-full">
                    <label for="cropGoal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <circle cx="12" cy="12" r="6" />
                            <circle cx="12" cy="12" r="2" />
                        </svg> Farming goal</label>
                    <input type="text" id="cropGoal" name="goal"
                        placeholder="e.g. Feed my family and sell surplus at the local market">
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit" id="cropSubmitBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 11l3 3 8-8" />
                        <path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h9" />
                    </svg>
                    Get Recommendations
                </button>
            </div>
        </form>

        <div id="cropResult"></div>
    </main>

    <script src="js/app.js"></script>
    <script src="js/crop-advisor.js"></script>
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