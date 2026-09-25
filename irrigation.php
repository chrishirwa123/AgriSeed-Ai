<?php
// AgriSeed AI — Smart Irrigation Advisor (Updated to match index.php styling)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Irrigation</title>
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

    .nav-links a:hover,
    .nav-links a.active {
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

    /* ===== MAIN CONTENT & FORM ===== */
    .page-header {
        margin-bottom: 28px;
    }

    .page-header h2 {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header h2 svg {
        width: 28px;
        height: 28px;
        color: var(--sky);
    }

    .card-muted {
        color: var(--ink-soft);
        font-size: .95rem;
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 28px;
        box-shadow: var(--shadow-sm);
    }

    .grid {
        display: grid;
        gap: 20px;
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field label {
        font-size: .88rem;
        font-weight: 600;
        color: var(--ink);
    }

    .field input,
    .field select {
        padding: 11px 14px;
        border-radius: 10px;
        border: 1px solid var(--line);
        background: var(--bg);
        font-family: inherit;
        font-size: .92rem;
        color: var(--ink);
        transition: border-color .18s, background .18s;
    }

    .field input:focus,
    .field select:focus {
        outline: none;
        border-color: var(--brand);
        background: var(--surface);
    }

    /* ===== BUTTONS ===== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 22px;
        border-radius: 11px;
        font-weight: 600;
        font-size: .95rem;
        cursor: pointer;
        transition: transform .18s, box-shadow .18s, background .18s;
        border: none;
        width: 100%;
        margin-top: 10px;
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

    .btn-primary svg {
        width: 18px;
        height: 18px;
    }

    /* ===== FOOTER ===== */
    .site-footer {
        border-top: 1px solid var(--line);
        background: var(--surface);
        padding: 34px 0;
        margin-top: 60px;
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

        .grid-2 {
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
                <li><a href="irrigation.php" class="active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <main class="container" style="padding-top: 40px; padding-bottom: 60px; max-width: 820px;">
        <div class="page-header">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                </svg>
                Smart Irrigation Advisor
            </h2>
            <p class="card-muted">General guidance on watering timing — not an exact scientific measurement. Actual
                needs depend on your crop, soil, weather, and field conditions.</p>
        </div>

        <form id="irrigationForm" class="card">
            <div class="grid grid-2">
                <div class="field">
                    <label for="irrCrop">Crop</label>
                    <input type="text" id="irrCrop" name="crop" placeholder="e.g. Tomatoes">
                </div>
                <div class="field">
                    <label for="irrStage">Growth stage</label>
                    <select id="irrStage" name="growthStage">
                        <option value="">Not sure</option>
                        <option>Seedling</option>
                        <option>Vegetative</option>
                        <option>Flowering</option>
                        <option>Fruiting</option>
                        <option>Maturity</option>
                    </select>
                </div>
                <div class="field">
                    <label for="irrSoil">Soil type</label>
                    <select id="irrSoil" name="soilType">
                        <option value="">Not sure</option>
                        <option>Clay</option>
                        <option>Sandy</option>
                        <option>Loam</option>
                        <option>Silty</option>
                    </select>
                </div>
                <div class="field">
                    <label for="irrTemp">Temperature (°C)</label>
                    <input type="number" id="irrTemp" name="temperature" placeholder="e.g. 28">
                </div>
                <div class="field">
                    <label for="irrHumidity">Humidity (%)</label>
                    <input type="number" id="irrHumidity" name="humidity" placeholder="e.g. 55">
                </div>
                <div class="field">
                    <label for="irrRain">Recent rainfall</label>
                    <select id="irrRain" name="recentRainfall">
                        <option value="">Not sure</option>
                        <option>None in the last week</option>
                        <option>Light rain recently</option>
                        <option>Heavy rain recently</option>
                    </select>
                </div>
                <div class="field">
                    <label for="irrWater">Water availability</label>
                    <select id="irrWater" name="waterAvailability">
                        <option value="">Not sure</option>
                        <option>Plenty</option>
                        <option>Limited</option>
                        <option>Very scarce</option>
                    </select>
                </div>
                <div class="field">
                    <label for="irrMoisture">Soil moisture (if known)</label>
                    <input type="text" id="irrMoisture" name="soilMoisture" placeholder="e.g. Dry to 5cm depth">
                </div>
            </div>
            <button class="btn btn-primary" type="submit" id="irrigationSubmitBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                </svg>
                Get Irrigation Advice
            </button>
        </form>

        <div id="irrigationResult" style="margin-top:20px;"></div>
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
    <script src="js/irrigation.js"></script>
    <script>
    (function() {
        // Toggle Mobile Navigation Menu
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