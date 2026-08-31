<?php
/**
 * AgriSeed AI — backend configuration
 *
 * API keys are NEVER hard-coded here and NEVER sent to the frontend.
 * They are read from environment variables. For local development
 * without editing your server/php.ini, copy secrets.example.php to
 * secrets.php (same folder) and fill in your keys — secrets.php is
 * already listed in .gitignore so it will not be committed.
 */

// Load local secrets file if present (developer convenience, git-ignored)
$secretsFile = __DIR__ . '/secrets.php';
if (file_exists($secretsFile)) {
    require_once $secretsFile;
}

function env_or(string $name, ?string $default = null): ?string {
    $value = getenv($name);
    if ($value !== false && $value !== '') {
        return $value;
    }
    if (defined($name)) {
        return constant($name);
    }
    return $default;
}

// ---- AI provider (Google Gemini API) ----
// Guarded with !defined() because secrets.php (loaded above) may already
// define these directly — avoids "Constant already defined" warnings.
if (!defined('GEMINI_API_KEY')) {
    define('GEMINI_API_KEY', env_or('GEMINI_API_KEY', ''));
}
define('GEMINI_API_BASE', 'https://generativelanguage.googleapis.com/v1beta/models');
// Gemini has a genuine free tier (rate-limited). gemini-2.5-flash is a
// stable, vision-capable model as of writing. Check https://ai.google.dev
// for the current recommended model name if this becomes outdated.
if (!defined('GEMINI_MODEL')) {
  define('GEMINI_MODEL', env_or('GEMINI_MODEL', 'gemini-3.6-flash'));
}

// ---- Weather provider (OpenWeatherMap) ----
if (!defined('OPENWEATHER_API_KEY')) {
    define('OPENWEATHER_API_KEY', env_or('OPENWEATHER_API_KEY', ''));
}
define('OPENWEATHER_URL', 'https://api.openweathermap.org/data/2.5/weather');

// ---- Reverse geocoding (OpenStreetMap Nominatim — free, no key needed) ----
define('NOMINATIM_URL', 'https://nominatim.openstreetmap.org/reverse');
// Nominatim's usage policy requires a real identifying User-Agent.
define('NOMINATIM_USER_AGENT', 'AgriSeedAI/1.0 (contact: set-your-email@example.com)');

// ---- Uploads ----
define('UPLOAD_DIR', __DIR__ . '/../uploads');
define('MAX_UPLOAD_BYTES', 6 * 1024 * 1024); // 6MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);

// ---- Basic request throttling (very simple, file-based, per IP) ----
define('RATE_LIMIT_DIR', sys_get_temp_dir() . '/agriseed_ratelimit');
define('RATE_LIMIT_MAX_REQUESTS', 20);   // per window
define('RATE_LIMIT_WINDOW_SECONDS', 60);

// ---- CORS / headers helper ----
function agriseed_json_headers(): void {
    header('Content-Type: application/json; charset=utf-8');
    // Same-origin app: no wildcard CORS. Adjust only if the frontend
    // is genuinely served from a different origin.
}

function agriseed_send_error(int $httpCode, string $userMessage, ?string $debug = null): void {
    http_response_code($httpCode);
    agriseed_json_headers();
    $payload = ['success' => false, 'error' => $userMessage];
    if ($debug !== null && env_or('APP_DEBUG', '0') === '1') {
        $payload['debug'] = $debug;
    }
    echo json_encode($payload);
    exit;
}

function agriseed_check_rate_limit(string $bucket): void {
    if (!is_dir(RATE_LIMIT_DIR)) {
        @mkdir(RATE_LIMIT_DIR, 0700, true);
    }
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $file = RATE_LIMIT_DIR . '/' . preg_replace('/[^a-zA-Z0-9_.]/', '_', $bucket . '_' . $ip) . '.json';
    $now = time();
    $data = ['count' => 0, 'windowStart' => $now];
    if (file_exists($file)) {
        $existing = json_decode((string) file_get_contents($file), true);
        if (is_array($existing)) {
            $data = $existing;
        }
    }
    if ($now - $data['windowStart'] > RATE_LIMIT_WINDOW_SECONDS) {
        $data = ['count' => 0, 'windowStart' => $now];
    }
    $data['count']++;
    file_put_contents($file, json_encode($data));
    if ($data['count'] > RATE_LIMIT_MAX_REQUESTS) {
        agriseed_send_error(429, 'Too many requests. Please wait a moment and try again.');
    }
}