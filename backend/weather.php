<?php
/**
 * GET /backend/weather.php?lat=..&lon=..
 * Returns current weather for a coordinate, or a clear
 * "unavailable" response if no API key is configured or the call fails.
 */

require_once __DIR__ . '/config.php';

agriseed_json_headers();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    agriseed_send_error(405, 'Method not allowed.');
}

agriseed_check_rate_limit('weather');

$lat = $_GET['lat'] ?? null;
$lon = $_GET['lon'] ?? null;

if (!is_numeric($lat) || !is_numeric($lon)) {
    agriseed_send_error(400, 'Missing or invalid coordinates.');
}

if (empty(OPENWEATHER_API_KEY)) {
    echo json_encode([
        'success' => false,
        'available' => false,
        'message' => 'Weather data unavailable',
    ]);
    exit;
}

$url = OPENWEATHER_URL . '?' . http_build_query([
    'lat' => $lat,
    'lon' => $lon,
    'appid' => OPENWEATHER_API_KEY,
    'units' => 'metric',
]);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 12,
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    // Graceful fallback — never invent weather values.
    echo json_encode([
        'success' => false,
        'available' => false,
        'message' => 'Weather data unavailable',
    ]);
    exit;
}

$data = json_decode($response, true);

echo json_encode([
    'success' => true,
    'available' => true,
    'temperature' => $data['main']['temp'] ?? null,
    'humidity' => $data['main']['humidity'] ?? null,
    'condition' => $data['weather'][0]['description'] ?? null,
    'wind' => $data['wind']['speed'] ?? null,
    'locationName' => $data['name'] ?? null,
]);
