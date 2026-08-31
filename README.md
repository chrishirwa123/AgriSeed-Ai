# AgriSeed AI

**Intelligent Agriculture. Better Decisions.**

A real, working agriculture-assistant web app: an AI chat assistant, a
photo-based Plant Doctor (vision AI), a Crop Advisor, and a Smart
Irrigation Advisor — in English and Kinyarwanda, with browser location
detection and live weather. Part of the AgriSeed Rover project (this
app is the software side only; it does not monitor the physical rover).

## How it's built

```
Frontend (HTML/CSS/JS)  →  Backend (PHP)  →  Google Gemini API
                                          →  OpenWeatherMap (weather)
                                          →  OpenStreetMap Nominatim (reverse geocoding, free, no key)
```

The AI API key never touches the browser — every AI/weather/location
call goes through a PHP endpoint in `/backend`, which holds the keys
server-side.

```
agri-seed-ai/
├── index.php              Landing page
├── dashboard.php          Greeting, location, weather, quick actions
├── assistant.php          AI chat
├── crop-advisor.php       Crop recommendation form
├── plant-doctor.php       Plant photo upload + analysis
├── irrigation.php         Irrigation advisor form
├── css/style.css
├── js/
│   ├── app.js               shared helpers (language, session storage, fetch)
│   ├── location.js          geolocation + manual fallback + weather
│   ├── assistant.js         chat logic
│   ├── crop-advisor.js
│   ├── plant-doctor.js
│   └── irrigation.js
└── backend/
    ├── config.php           loads API keys, error/rate-limit helpers
    ├── secrets.example.php  copy → secrets.php and fill in your keys
    ├── gemini-client.php    shared Google Gemini API client
    ├── ai.php               chat / crop / irrigation AI endpoint
    ├── image-analysis.php   Plant Doctor vision endpoint
    ├── weather.php          OpenWeatherMap proxy
    └── location.php         reverse-geocoding proxy
```

## 1. Requirements

- PHP 8.0+ with the `curl` and `fileinfo` extensions enabled (both are
  on by default in most PHP installs).
- No database or Node.js build step is required for this version.

## 2. Get your API keys

### Gemini API key (required — powers all AI features, free tier available)
1. Go to https://aistudio.google.com/apikey and sign in with a Google account.
2. Click **Create API key** — no credit card required for the free tier.
3. Copy it — you'll paste it in step 3 below.
4. The free tier is rate-limited (a modest number of requests per
   minute/day) but is enough for development and demos.
5. `GEMINI_MODEL` defaults to `gemini-2.5-flash` in `config.php`. If
   that name is ever retired, check https://ai.google.dev/gemini-api/docs/models
   for the current vision-capable model name and update the constant.

### OpenWeatherMap key (optional — only needed for the weather card)
1. Go to https://openweathermap.org/api and create a free account.
2. Copy your API key (new keys can take a few minutes to activate).
3. Without this key, the app will honestly show **"Weather data
   unavailable"** instead of making anything up.

Reverse geocoding (turning coordinates into a district/province name)
uses OpenStreetMap's free Nominatim service — no key needed.

## 3. Configure your keys

```bash
cp backend/secrets.example.php backend/secrets.php
```

Then edit `backend/secrets.php`:

```php
define('GEMINI_API_KEY', 'your-real-gemini-key');
define('OPENWEATHER_API_KEY', 'your-real-openweathermap-key');
```

`secrets.php` is already listed in `.gitignore` so it won't be
committed. In production, prefer setting real environment variables
(`GEMINI_API_KEY`, `OPENWEATHER_API_KEY`) on the server instead of
using this file.

## 4. Run it locally

```bash
cd agri-seed-ai
php -S localhost:8000
```

Open http://localhost:8000/index.php in your browser.

(Any standard PHP host — Apache, Nginx+PHP-FPM, shared hosting — works
too; just point the document root at this folder.)

## 5. Test it

- **Chat**: open **AI Assistant**, ask "Why are my maize leaves
  yellow?" — you should get a real Gemini-generated answer, not a
  canned reply.
- **Plant Doctor**: upload any plant/leaf photo — the analysis in the
  result card is generated live from that specific image.
- **Crop Advisor / Irrigation**: fill the form and submit — the
  recommendation text is generated from what you typed, not
  hard-coded.
- **Location**: on the Dashboard, click "Use My Location" and accept
  the browser permission prompt — it should resolve to a real
  district/province name. Try "Enter Manually" too.
- **Weather**: once location is set (via GPS), the weather card should
  show a live temperature — or "Weather data unavailable" if no
  OpenWeatherMap key is configured.
- If you see "AgriSeed AI is not fully configured yet", it means
  `GEMINI_API_KEY` is still empty in `secrets.php`.
- If you see a "temporarily unavailable" message, temporarily add
  `define('APP_DEBUG', '1');` to `secrets.php`, restart the server, and
  check the Network tab in DevTools for the `"debug"` field in the
  failed response — it names the exact problem (missing key, bad key,
  rate limit, no network, etc.).

## 6. What's intentionally simple in this version

- **No database yet.** Chat history and location are kept only in the
  browser's `sessionStorage` (cleared when the tab closes) — nothing
  is written to a MySQL database in this version. Section 22 of the
  spec marks a DB as optional; the file list above leaves room to add
  one later (e.g. a `conversations` and `plant_analyses` table) without
  changing the frontend contract.
- **No voice input/output yet.** The chat UI has a slot for it, but
  speech-to-text/text-to-speech needs a separate provider decision
  (browser Web Speech API has weak Kinyarwanda support) — worth a
  dedicated follow-up rather than a half-working guess.
- **No explicit "Demo Mode" toggle.** Every feature calls the real
  Gemini/weather APIs; if a key is missing, you get an honest
  "unavailable" message rather than fabricated demo data. A true demo
  mode (canned, clearly-labeled sample responses for offline
  demonstrations) can be added as a `?demo=1` flag if you need it for
  judging without live internet.

## 7. Security notes

- API keys live only in `backend/secrets.php` (git-ignored) or server
  environment variables — never in JavaScript.
- Uploaded plant photos are validated (type, size, real image check)
  and analyzed in memory; they are **not saved to disk**.
- A simple per-IP rate limiter (20 requests/minute per endpoint) is
  built into `config.php` to reduce abuse — tune
  `RATE_LIMIT_MAX_REQUESTS` there for your needs.
- Location is kept only in `sessionStorage` on the visitor's own
  device, never written server-side.
