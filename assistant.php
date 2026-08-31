<?php
// AgriSeed AI — Assistant Page (Updated with distinct User vs AI layout & avatars)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Assistant — AgriSeed AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --bg: #f4f7f5;
        --surface: #ffffff;
        --ink: #0f1f17;
        --ink-soft: #4a5b52;
        --muted: #82928a;
        --line: #e2ede5;
        --brand: #1f7a4d;
        --brand-600: #176b41;
        --brand-700: #125936;
        --brand-50: #eef7f2;
        --leaf: #3aa66a;
        --accent: #e8a13a;
        --accent-50: #fdf6ec;

        /* Message Colors */
        --user-bg: #1f7a4d;
        --user-text: #ffffff;
        --ai-bg: #ffffff;
        --ai-text: #0f1f17;
        --ai-border: #d0e0d5;

        --shadow-sm: 0 2px 4px rgba(15, 31, 23, .04);
        --shadow-md: 0 6px 20px rgba(15, 31, 23, .06);
        --shadow-lg: 0 16px 40px -10px rgba(15, 31, 23, .12);
        --radius: 14px;
        --radius-lg: 20px;
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
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    h1,
    h2,
    h3,
    h4 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1.25;
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

    /* ===== NAVIGATION ===== */
    .topnav {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(255, 255, 255, .88);
        backdrop-filter: saturate(180%) blur(14px);
        -webkit-backdrop-filter: saturate(180%) blur(14px);
        border-bottom: 1px solid var(--line);
    }

    .topnav .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
        position: relative;
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
        box-shadow: 0 6px 16px -4px rgba(31, 122, 77, .4);
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
        font-weight: 600;
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
    main.container {
        padding: 24px 24px 36px;
        max-width: 980px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .page-head {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-head .ico {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        flex: 0 0 auto;
        background: linear-gradient(135deg, var(--brand), var(--leaf));
        display: grid;
        place-items: center;
        color: #fff;
        box-shadow: 0 8px 20px -5px rgba(31, 122, 77, .45);
    }

    .page-head .ico svg {
        width: 26px;
        height: 26px;
    }

    .page-head h1 {
        font-size: 1.65rem;
        font-weight: 800;
    }

    .page-head p {
        color: var(--ink-soft);
        font-size: .95rem;
    }

    /* ===== CHAT SHELL ===== */
    .chat-shell {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 215px);
        min-height: 520px;
    }

    /* TOOLBAR HEADER */
    .chat-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 22px;
        border-bottom: 1px solid var(--line);
        background: rgba(255, 255, 255, .95);
    }

    .chat-toolbar-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-toolbar-title .avatar-ai {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        flex: 0 0 auto;
        background: linear-gradient(135deg, var(--brand), var(--leaf));
        display: grid;
        place-items: center;
        color: #fff;
        box-shadow: 0 4px 12px -2px rgba(31, 122, 77, .4);
    }

    .chat-toolbar-title .avatar-ai svg {
        width: 20px;
        height: 20px;
    }

    .chat-toolbar-title strong {
        font-family: 'Plus Jakarta Sans';
        font-size: 1.05rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chat-toolbar-title .status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .75rem;
        font-weight: 600;
        color: var(--brand);
        background: var(--brand-50);
        padding: 2px 8px;
        border-radius: 999px;
    }

    .chat-toolbar-title .status::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--leaf);
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(58, 166, 106, .6);
        }

        50% {
            box-shadow: 0 0 0 5px rgba(58, 166, 106, 0);
        }
    }

    .chat-toolbar-title .card-muted {
        font-size: .78rem;
        color: var(--muted);
    }

    .toolbar-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .lang-group {
        display: inline-flex;
        align-items: center;
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 3px;
        gap: 2px;
    }

    .lang-group .btn-outline.btn-sm {
        border: none;
        background: transparent;
        padding: 5px 11px;
        border-radius: 7px;
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink-soft);
    }

    .lang-group .btn-outline.btn-sm.active {
        background: var(--surface);
        color: var(--brand-700);
        box-shadow: var(--shadow-sm);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 11px;
        font-weight: 600;
        font-size: .92rem;
        cursor: pointer;
        transition: all .18s ease;
        border: none;
        font-family: inherit;
    }

    .btn-sm {
        padding: 7px 12px;
        font-size: .82rem;
        border-radius: 99px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--brand), var(--brand-600));
        color: #fff;
        box-shadow: 0 6px 16px -4px rgba(31, 122, 77, .45);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px -6px rgba(31, 122, 77, .55);
    }

    .btn-outline {
        background: var(--surface);
        color: var(--ink-soft);
        border: 1px solid var(--line);
    }

    .btn-outline:hover {
        border-color: var(--brand);
        color: var(--brand-700);
        background: var(--brand-50);
    }

    .btn-outline.danger:hover {
        border-color: #e55353;
        color: #e55353;
        background: #fdf2f2;
    }

    /* ===== CHAT LOG STREAM & BUBBLES ===== */
    .chat-log {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        background: var(--bg);
        scroll-behavior: smooth;
    }

    .chat-log:empty::before {
        content: "Ask AgriSeed AI any question about your crops, soil, or farming techniques.";
        color: var(--muted);
        font-size: .92rem;
        text-align: center;
        margin: auto;
        font-family: 'Plus Jakarta Sans';
        font-weight: 500;
        background: var(--surface);
        padding: 18px 24px;
        border-radius: var(--radius);
        border: 1px dashed var(--line);
    }

    /* Base Message Structure */
    .msg {
        display: flex;
        gap: 12px;
        max-width: 78%;
        align-items: flex-end;
        animation: rise .22s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes rise {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Avatar Styling */
    .msg .avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        flex: 0 0 auto;
        display: grid;
        place-items: center;
        box-shadow: var(--shadow-sm);
    }

    .msg .avatar svg {
        width: 18px;
        height: 18px;
    }

    /* Base Bubble Structure */
    .bubble {
        padding: 13px 18px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.55;
        word-break: break-word;
        position: relative;
        box-shadow: var(--shadow-sm);
    }

    .bubble .meta {
        display: block;
        margin-top: 6px;
        font-size: 0.70rem;
        opacity: 0.75;
        text-align: right;
    }

    /* AI RESPONSE (LEFT ALIGNED) */
    .msg.ai {
        align-self: flex-start;
        flex-direction: row;
    }

    .msg.ai .avatar {
        background: linear-gradient(135deg, var(--brand), var(--leaf));
        color: #ffffff;
        box-shadow: 0 4px 12px -2px rgba(31, 122, 77, 0.35);
    }

    .msg.ai .bubble {
        background: var(--surface);
        color: var(--ink);
        border: 1px solid var(--line);
        border-bottom-left-radius: 4px;
    }

    /* USER QUESTION (RIGHT ALIGNED) */
    .msg.user {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .msg.user .avatar {
        background: var(--ink);
        color: #ffffff;
    }

    .msg.user .bubble {
        background: var(--brand);
        color: #ffffff;
        border: 1px solid var(--brand-600);
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 14px -3px rgba(31, 122, 77, 0.35);
    }

    .msg.user .bubble .meta {
        color: rgba(255, 255, 255, 0.8);
    }

    /* QUICK SUGGESTIONS */
    .suggestions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        padding: 12px 22px;
        border-top: 1px solid var(--line);
        background: var(--surface);
    }

    .suggestions .chip {
        font-size: .82rem;
        font-weight: 500;
        color: var(--ink-soft);
        background: var(--bg);
        border: 1px solid var(--line);
        padding: 7px 13px;
        border-radius: 999px;
        cursor: pointer;
        transition: all .18s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .suggestions .chip:hover {
        background: var(--brand-50);
        color: var(--brand-700);
        border-color: var(--brand);
        transform: translateY(-1px);
    }

    /* INPUT ROW */
    .chat-input-row {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        padding: 14px 22px;
        border-top: 1px solid var(--line);
        background: var(--surface);
    }

    .icon-btn {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        flex: 0 0 auto;
        display: grid;
        place-items: center;
        cursor: pointer;
        background: var(--bg);
        border: 1px solid var(--line);
        color: var(--ink-soft);
        transition: all .18s ease;
    }

    .icon-btn:hover {
        background: var(--brand-50);
        color: var(--brand-700);
        border-color: var(--brand);
    }

    .icon-btn svg {
        width: 20px;
        height: 20px;
    }

    textarea#chatInput {
        flex: 1;
        resize: none;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 12px 16px;
        font-family: inherit;
        font-size: .95rem;
        line-height: 1.5;
        color: var(--ink);
        background: var(--bg);
        max-height: 130px;
        transition: border-color .18s, background .18s, box-shadow .18s;
    }

    textarea#chatInput:focus {
        outline: none;
        border-color: var(--brand);
        background: var(--surface);
        box-shadow: 0 0 0 3.5px rgba(31, 122, 77, .12);
    }

    textarea#chatInput::placeholder {
        color: var(--muted);
    }

    #sendBtn {
        height: 44px;
        padding: 0 20px;
        border-radius: 12px;
    }

    /* RESPONSIVE DESIGN */
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

        .chat-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .toolbar-actions {
            justify-content: space-between;
        }

        .msg {
            max-width: 90%;
        }

        main.container {
            padding: 16px 14px 24px;
        }

        .chat-shell {
            height: calc(100vh - 180px);
            border-radius: 16px;
        }

        #sendBtn span {
            display: none;
        }

        #sendBtn {
            padding: 0 14px;
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
                <li><a href="assistant.php" class="active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 8V4H8" />
                            <rect width="16" height="12" x="4" y="8" rx="2" />
                            <path d="M2 14h2" />
                            <path d="M20 14h2" />
                            <path d="M15 13v2" />
                            <path d="M9 13v2" />
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

    <main class="container">
        <div class="page-head">
            <span class="ico">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
            </span>
            <div>
                <h1>AI Agriculture Assistant</h1>
                <p>Ask about pests, soil, watering, or what to plant — in English or Kinyarwanda.</p>
            </div>
        </div>

        <div class="chat-shell">
            <div class="chat-toolbar">
                <div class="chat-toolbar-title">
                    <span class="avatar-ai">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 8V4H8" />
                            <rect width="16" height="12" x="4" y="8" rx="2" />
                            <path d="M2 14h2" />
                            <path d="M20 14h2" />
                            <path d="M15 13v2" />
                            <path d="M9 13v2" />
                        </svg>
                    </span>
                    <div>
                        <strong>AgriSeed AI <span class="status">Online</span></strong>
                        <div class="card-muted">Agricultural Expert System</div>
                    </div>
                </div>
                <div class="toolbar-actions">
                    <div class="lang-group">
                        <button class="btn btn-outline btn-sm" data-lang-option="en">EN</button>
                        <button class="btn btn-outline btn-sm" data-lang-option="rw">RW</button>
                        <button class="btn btn-outline btn-sm" data-lang-option="auto">Auto</button>
                    </div>
                    <button class="btn btn-outline btn-sm danger" id="clearChatBtn" type="button"
                        title="Clear conversation">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        </svg>
                        Clear
                    </button>
                </div>
            </div>

            <div class="chat-log" id="chatLog" aria-live="polite"></div>

            <div class="suggestions" id="suggestions">
                <button class="chip" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" width="14" height="14">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg>
                    Why are my maize leaves yellow?
                </button>
                <button class="chip" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" width="14" height="14">
                        <path d="M12 2v6" />
                        <path d="M5.5 8 12 14" />
                        <path d="M18.5 8 12 14" />
                        <path d="M12 22V14" />
                    </svg>
                    What can I plant this season?
                </button>
                <button class="chip" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" width="14" height="14">
                        <path d="M12 22a7 7 0 0 0 7-7c0-4-7-13-7-13S5 11 5 15a7 7 0 0 0 7 7z" />
                    </svg>
                    How often should I water beans?
                </button>
                <button class="chip" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" width="14" height="14">
                        <path d="M12 20v-6" />
                        <path d="M6 20v-4" />
                        <path d="M18 20v-8" />
                    </svg>
                    Best fertilizer for tomato?
                </button>
            </div>

            <form class="chat-input-row" id="chatForm">
                <button type="button" class="icon-btn" title="Attach image (use Plant Doctor for photo analysis)"
                    onclick="location.href='plant-doctor.php'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                </button>
                <textarea id="chatInput" rows="1" placeholder="Type your farming question..."
                    aria-label="Your question"></textarea>
                <button type="submit" class="btn btn-primary" id="sendBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                    <span>Send</span>
                </button>
            </form>
        </div>
    </main>

    <script src="js/app.js"></script>
    <script src="js/assistant.js"></script>
    <script>
    (function() {
        var t = document.querySelector('.nav-toggle'),
            l = document.querySelector('.nav-links');
        if (t && l) {
            t.addEventListener('click', function() {
                l.classList.toggle('open');
            });
        }
        var chips = document.querySelectorAll('#suggestions .chip');
        var input = document.getElementById('chatInput');
        chips.forEach(function(c) {
            c.addEventListener('click', function() {
                if (input) {
                    input.value = c.textContent.trim();
                    input.focus();
                }
            });
        });
    })();
    </script>
</body>

</html>