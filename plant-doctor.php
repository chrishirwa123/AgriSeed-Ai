<?php
// AgriSeed AI — Plant Doctor (UI match with index.php design system)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Doctor — AgriSeed AI</title>
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

    /* ===== PAGE HEADER ===== */
    .page-header {
        padding: 50px 0 20px;
    }

    .page-header h1 {
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .page-header p {
        color: var(--ink-soft);
        font-size: 1.05rem;
        max-width: 640px;
    }

    /* ===== DOCTOR CARD & UPLOAD UI ===== */
    .doctor-section {
        padding: 20px 0 80px;
    }

    .doctor-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 36px;
        box-shadow: var(--shadow-sm);
        max-width: 780px;
        margin: 0 auto;
    }

    .upload-drop {
        border: 2px dashed var(--line);
        border-radius: var(--radius);
        padding: 40px 20px;
        text-align: center;
        background: var(--bg);
        cursor: pointer;
        transition: border-color .2s, background .2s, transform .2s;
        outline: none;
    }

    .upload-drop:hover,
    .upload-drop:focus,
    .upload-drop.dragover {
        border-color: var(--brand);
        background: var(--brand-50);
    }

    .upload-drop-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: var(--brand-50);
        color: var(--brand-700);
        display: grid;
        place-items: center;
        margin: 0 auto 16px;
    }

    .upload-drop-icon svg {
        width: 28px;
        height: 28px;
    }

    .upload-drop p {
        font-size: 1rem;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .upload-drop .card-muted {
        font-size: .85rem;
        color: var(--muted);
    }

    .visually-hidden {
        position: absolute !important;
        height: 1px;
        width: 1px;
        overflow: hidden;
        clip: rect(1px, 1px, 1px, 1px);
        white-space: nowrap;
    }

    .preview-container {
        position: relative;
        margin-top: 20px;
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--line);
        display: none;
    }

    .preview-container img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        display: block;
    }

    .btn-remove-preview {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(15, 31, 23, 0.75);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        backdrop-filter: blur(4px);
        transition: background .18s;
    }

    .btn-remove-preview:hover {
        background: rgba(15, 31, 23, 0.9);
    }

    .field {
        margin-top: 24px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .field label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: .95rem;
        color: var(--ink);
    }

    .field textarea {
        width: 100%;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: .95rem;
        padding: 14px 16px;
        border: 1.5px solid var(--line);
        border-radius: 12px;
        background: var(--bg);
        color: var(--ink);
        resize: vertical;
        outline: none;
        transition: border-color .18s, box-shadow .18s, background .18s;
    }

    .field textarea:focus {
        border-color: var(--brand);
        background: var(--surface);
        box-shadow: 0 0 0 4px rgba(31, 122, 77, .12);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 26px;
        border-radius: 13px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: transform .18s, box-shadow .18s, background .18s;
        border: none;
        width: 100%;
        margin-top: 24px;
    }

    .btn svg {
        width: 19px;
        height: 19px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--brand), var(--brand-600));
        color: #fff;
        box-shadow: 0 12px 26px -8px rgba(31, 122, 77, .6);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px -10px rgba(31, 122, 77, .7);
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
    @media (max-width: 760px) {
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

        .doctor-card {
            padding: 24px;
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
                <li><a href="plant-doctor.php" class="active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
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
        <header class="page-header">
            <h1>Plant Doctor</h1>
            <p>Upload a photo of a plant or leaf for an AI health check. This is an agricultural aid, not a lab
                diagnosis.</p>
        </header>

        <section class="doctor-section">
            <form id="plantDoctorForm" class="doctor-card" enctype="multipart/form-data">
                <div class="upload-drop" id="uploadDrop" tabindex="0" role="button" aria-label="Upload photo area">
                    <div class="upload-drop-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                    </div>
                    <p><strong>Click to upload</strong> or drag a photo here</p>
                    <p class="card-muted">JPG, PNG, or WEBP · up to 6MB</p>
                </div>

                <input type="file" id="plantImageInput" name="plantImage" accept="image/jpeg,image/png,image/webp"
                    capture="environment" class="visually-hidden">

                <div id="imagePreviewContainer" class="preview-container">
                    <img id="imagePreview" alt="Selected plant photo preview">
                    <button type="button" id="removeImageBtn" class="btn-remove-preview">✕ Remove</button>
                </div>

                <div class="field">
                    <label for="plantDescription">Optional description</label>
                    <textarea id="plantDescription" name="description" rows="3"
                        placeholder="e.g. Tomato leaves turning yellow from the bottom up, past week"></textarea>
                </div>

                <button class="btn btn-primary" type="submit" id="plantSubmitBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                        <path d="M5 14c1.5-1.5 3-3.5 3-6a4 4 0 0 0-8 0c0 2.5 1.5 4.5 3 6" />
                        <path d="M12 22V12" />
                    </svg>
                    <span class="btn-text">Analyze Photo</span>
                    <span class="btn-spinner" style="display: none;">⏳ Analyzing...</span>
                </button>
            </form>

            <div id="plantResult" style="margin-top: 2rem; max-width: 780px; margin-left: auto; margin-right: auto;">
            </div>
        </section>
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
    <script src="js/plant-doctor.js"></script>
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