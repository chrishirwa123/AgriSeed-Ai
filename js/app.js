/* Shared AgriSeed AI utilities, loaded on every page. */

const AgriSeed = (() => {
  const LANG_KEY = 'agriseed_language';       // 'en' | 'rw' | 'auto'
  const LOCATION_KEY = 'agriseed_location';   // { lat, lon, label } — session only
  const WEATHER_KEY = 'agriseed_weather';     // cached weather summary

  function getLanguage() {
    return localStorage.getItem(LANG_KEY) || 'auto';
  }

  function setLanguage(lang) {
    localStorage.setItem(LANG_KEY, lang);
    document.dispatchEvent(new CustomEvent('agriseed:language-changed', { detail: { lang } }));
  }

  // Location/weather are session-only (not permanently stored) per the
  // project's privacy requirement — cleared when the browser tab session ends.
  function getLocation() {
    try {
      const raw = sessionStorage.getItem(LOCATION_KEY);
      return raw ? JSON.parse(raw) : null;
    } catch { return null; }
  }

  function setLocation(loc) {
    sessionStorage.setItem(LOCATION_KEY, JSON.stringify(loc));
    document.dispatchEvent(new CustomEvent('agriseed:location-changed', { detail: loc }));
  }

  function clearLocation() {
    sessionStorage.removeItem(LOCATION_KEY);
    sessionStorage.removeItem(WEATHER_KEY);
  }

  function getWeather() {
    try {
      const raw = sessionStorage.getItem(WEATHER_KEY);
      return raw ? JSON.parse(raw) : null;
    } catch { return null; }
  }

  function setWeather(w) {
    sessionStorage.setItem(WEATHER_KEY, JSON.stringify(w));
  }

  async function postJSON(url, body) {
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    });
    let data;
    try { data = await res.json(); }
    catch { throw new Error('AgriSeed AI is temporarily unavailable. Please try again.'); }
    if (!res.ok || data.success === false) {
      throw new Error(data.error || 'AgriSeed AI is temporarily unavailable. Please try again.');
    }
    return data;
  }

  async function getJSON(url) {
    const res = await fetch(url);
    let data;
    try { data = await res.json(); }
    catch { throw new Error('Something went wrong. Please try again.'); }
    if (!res.ok) {
      throw new Error(data.error || 'Something went wrong. Please try again.');
    }
    return data;
  }

  function initNav() {
    const toggle = document.querySelector('.nav-toggle');
    const links = document.querySelector('.nav-links');
    if (toggle && links) {
      toggle.addEventListener('click', () => links.classList.toggle('open'));
    }
    // Highlight current page
    const path = location.pathname.split('/').pop() || 'index.php';
    document.querySelectorAll('.nav-links a').forEach(a => {
      if (a.getAttribute('href') === path) a.classList.add('active');
    });
  }

  function initLanguageSwitcher() {
    const buttons = document.querySelectorAll('[data-lang-option]');
    const current = getLanguage();
    buttons.forEach(btn => {
      if (btn.dataset.langOption === current) btn.classList.add('active-lang');
      btn.addEventListener('click', () => {
        buttons.forEach(b => b.classList.remove('active-lang'));
        btn.classList.add('active-lang');
        setLanguage(btn.dataset.langOption);
      });
    });
  }

  function greeting() {
    const hour = new Date().getHours();
    if (hour < 12) return 'Good morning!';
    if (hour < 17) return 'Good afternoon!';
    return 'Good evening!';
  }

  document.addEventListener('DOMContentLoaded', () => {
    initNav();
    initLanguageSwitcher();
  });

  return {
    getLanguage, setLanguage,
    getLocation, setLocation, clearLocation,
    getWeather, setWeather,
    postJSON, getJSON,
    greeting,
  };
})();
