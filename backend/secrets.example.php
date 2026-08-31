<?php
/**
 * Copy this file to "secrets.php" in the same folder and fill in your
 * real keys. secrets.php is git-ignored and is only for local/dev use.
 * In production, prefer setting real environment variables instead.
 */

// Get a free Gemini API key at https://aistudio.google.com/apikey
// (no credit card required for the free tier)
define('GEMINI_API_KEY', 'YOUR_GEMINI_API_KEY_HERE');

// Get a free OpenWeatherMap key at https://openweathermap.org/api
// (Weather features show "Weather data unavailable" until this is set.)
define('OPENWEATHER_API_KEY', 'your-openweathermap-key-here');

// Uncomment while debugging to see the real error behind generic messages.
// Remove again once things are working.
// define('APP_DEBUG', '1');
