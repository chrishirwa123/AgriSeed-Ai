document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('cropForm');
  const resultBox = document.getElementById('cropResult');
  const locationField = document.getElementById('cropLocation');
  const submitBtn = document.getElementById('cropSubmitBtn');

  const savedLoc = AgriSeed.getLocation();
  if (savedLoc && savedLoc.label && locationField && !locationField.value) {
    locationField.value = savedLoc.label;
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    const context = Object.fromEntries(fd.entries());

    // Drop empty optional fields
    Object.keys(context).forEach(k => { if (context[k] === '') delete context[k]; });

    submitBtn.disabled = true;
    resultBox.innerHTML = '<div class="loading-row"><span class="spinner"></span> Analyzing your conditions…</div>';

    try {
      const data = await AgriSeed.postJSON('backend/ai.php', {
        mode: 'crop',
        language: AgriSeed.getLanguage(),
        context,
      });
      resultBox.innerHTML = `<div class="card"><div class="result-block"><div class="label">Recommended crops</div></div><div style="white-space:pre-wrap;">${escapeHtml(data.reply)}</div></div>`;
    } catch (err) {
      resultBox.innerHTML = `<div class="alert alert-danger">${escapeHtml(err.message)}</div>`;
    } finally {
      submitBtn.disabled = false;
    }
  });

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }
});
