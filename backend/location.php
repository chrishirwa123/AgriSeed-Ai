<?php
/**
 * GET /backend/location.php?lat=..&lon=..
 * Reverse-geocodes coordinates into country/province/district/city
 * using OpenStreetMap Nominatim (free, no API key required).
 * Location is NOT stored server-side — it is simply looked up and returned.
 */

require_once __DIR__ . '/config.php';

agriseed_json_headers();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    agriseed_send_error(405, 'Method not allowed.');
}

agriseed_check_rate_limit('location');

$lat = $_GET['lat'] ?? null;
$lon = $_GET['lon'] ?? null;

if (!is_numeric($lat) || !is_numeric($lon)) {
    agriseed_send_error(400, 'Missing or invalid coordinates.');
}

$url = NOMINATIM_URL . '?' . http_build_query([
    'lat' => $lat,
    'lon' => $lon,
    'format' => 'json',
    'zoom' => 10,
    'addressdetails' => 1,
]);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 12,
    CURLOPT_HTTPHEADER => ['User-Agent: ' . NOMINATIM_USER_AGENT],
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    agriseed_send_error(502, 'Could not determine your location right now. You can enter it manually instead.');
}

$data = json_decode($response, true);
$addr = $data['address'] ?? [];

echo json_encode([
    'success' => true,
    'country' => $addr['country'] ?? null,
    'province' => $addr['state'] ?? $addr['region'] ?? null,
    'district' => $addr['county'] ?? $addr['state_district'] ?? null,
    'city' => $addr['city'] ?? $addr['town'] ?? $addr['village'] ?? null,
    'displayName' => $data['display_name'] ?? null,
]);
