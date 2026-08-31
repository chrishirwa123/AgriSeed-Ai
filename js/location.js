/* Location + weather widget logic. Include on any page with a
   .location-widget element (id="locationWidget"). */

document.addEventListener("DOMContentLoaded", () => {
  const widget = document.getElementById("locationWidget");
  if (!widget) return;

  const useLocationBtn = widget.querySelector("#useLocationBtn");
  const manualToggleBtn = widget.querySelector("#manualLocationToggle");
  const manualForm = widget.querySelector("#manualLocationForm");
  const currentLabel = widget.querySelector("#locationLabel");
  const statusEl = widget.querySelector("#locationStatus");
  const weatherCard = document.getElementById("weatherCard");

  function renderSaved() {
    const loc = AgriSeed.getLocation();
    if (loc && loc.label) {
      currentLabel.textContent = loc.label;
      if (loc.lat && loc.lon) fetchWeather(loc.lat, loc.lon);
    } else {
      currentLabel.textContent = "Not set";
    }
  }

  function setStatus(msg, isError = false) {
    if (!statusEl) return;
    statusEl.textContent = msg;
    statusEl.className = isError ? "field-hint" : "field-hint";
    statusEl.style.color = isError
      ? "var(--color-danger)"
      : "var(--color-text-muted)";
  }

  async function fetchWeather(lat, lon) {
    if (!weatherCard) return;
    weatherCard.innerHTML =
      '<div class="loading-row"><span class="spinner"></span> Loading weather…</div>';
    try {
      const data = await AgriSeed.getJSON(
        `backend/weather.php?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`,
      );
      if (!data.available) {
        weatherCard.innerHTML = `<p class="card-muted">Weather data unavailable</p>`;
        return;
      }
      AgriSeed.setWeather(data);
      weatherCard.innerHTML = `
        <div class="weather-card">
          <div class="weather-temp">${Math.round(data.temperature)}°C</div>
          <div>
            <div style="font-weight:600; text-transform:capitalize;">${data.condition || ""}</div>
            <div class="card-muted">Humidity ${data.humidity ?? "—"}% · Wind ${data.wind ?? "—"} m/s</div>
          </div>
        </div>`;
    } catch (e) {
      weatherCard.innerHTML = `<p class="card-muted">Weather data unavailable</p>`;
    }
  }

  async function useBrowserLocation() {
    if (!navigator.geolocation) {
      setStatus(
        "Location is not supported on this browser. Please enter it manually.",
        true,
      );
      manualForm.classList.add("open");
      return;
    }
    setStatus("Requesting location permission…");
    navigator.geolocation.getCurrentPosition(
      async (position) => {
        const { latitude, longitude } = position.coords;
        setStatus("Looking up your area…");
        try {
          const geo = await AgriSeed.getJSON(
            `backend/location.php?lat=${latitude}&lon=${longitude}`,
          );
          const label =
            [geo.district, geo.province, geo.country]
              .filter(Boolean)
              .join(", ") ||
            geo.displayName ||
            `${latitude.toFixed(3)}, ${longitude.toFixed(3)}`;
          AgriSeed.setLocation({
            lat: latitude,
            lon: longitude,
            label,
            ...geo,
          });
          renderSaved();
          setStatus("Location detected.");
        } catch (e) {
          setStatus(
            "Could not determine your area. You can enter it manually.",
            true,
          );
          manualForm.classList.add("open");
        }
      },
      (err) => {
        let msg = "Could not access your location.";
        if (err.code === err.PERMISSION_DENIED)
          msg =
            "Location permission denied. You can enter your location manually instead.";
        setStatus(msg, true);
        manualForm.classList.add("open");
      },
      { enableHighAccuracy: false, timeout: 10000, maximumAge: 300000 },
    );
  }

  if (useLocationBtn)
    useLocationBtn.addEventListener("click", useBrowserLocation);

  if (manualToggleBtn) {
    manualToggleBtn.addEventListener("click", () =>
      manualForm.classList.toggle("open"),
    );
  }

  if (manualForm) {
    manualForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const city = manualForm.querySelector('[name="manualCity"]').value.trim();
      const district = manualForm
        .querySelector('[name="manualDistrict"]')
        .value.trim();
      const country = manualForm
        .querySelector('[name="manualCountry"]')
        .value.trim();
      const label = [city, district, country].filter(Boolean).join(", ");
      if (!label) return;
      AgriSeed.setLocation({ label, city, district, country, manual: true });
      renderSaved();
      setStatus("Location saved manually.");
      manualForm.classList.remove("open");
      if (weatherCard) {
        weatherCard.innerHTML = `<p class="card-muted">Weather needs GPS coordinates — use "Use My Location" for live weather, or check your local forecast separately.</p>`;
      }
    });
  }

  renderSaved();
});
