document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('irrigationForm');
  const resultBox = document.getElementById('irrigationResult');
  const submitBtn = document.getElementById('irrigationSubmitBtn');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    const context = Object.fromEntries(fd.entries());
    Object.keys(context).forEach(k => { if (context[k] === '') delete context[k]; });

    submitBtn.disabled = true;
    resultBox.innerHTML = '<div class="loading-row"><span class="spinner"></span> Working out irrigation guidance…</div>';

    try {
      const data = await AgriSeed.postJSON('backend/ai.php', {
        mode: 'irrigation',
        language: AgriSeed.getLanguage(),
        context,
      });
      resultBox.innerHTML = `<div class="card"><div class="result-block"><div class="label">Irrigation guidance</div></div><div style="white-space:pre-wrap;">${escapeHtml(data.reply)}</div></div>`;
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
