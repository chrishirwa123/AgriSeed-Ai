document.addEventListener('DOMContentLoaded', () => {
  const dropZone = document.getElementById('uploadDrop');
  const fileInput = document.getElementById('plantImageInput');
  const preview = document.getElementById('imagePreview');
  const form = document.getElementById('plantDoctorForm');
  const resultBox = document.getElementById('plantResult');
  const submitBtn = document.getElementById('plantSubmitBtn');

  let selectedFile = null;

  dropZone.addEventListener('click', () => fileInput.click());
  dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.style.borderColor = 'var(--color-primary)'; });
  dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = ''; });
  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = '';
    if (e.dataTransfer.files.length) {
      fileInput.files = e.dataTransfer.files;
      handleFile(e.dataTransfer.files[0]);
    }
  });

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length) handleFile(fileInput.files[0]);
  });

  function handleFile(file) {
    if (!file.type.startsWith('image/')) {
      resultBox.innerHTML = '<div class="alert alert-danger">Please choose an image file (JPG, PNG, or WEBP).</div>';
      return;
    }
    if (file.size > 6 * 1024 * 1024) {
      resultBox.innerHTML = '<div class="alert alert-danger">That image is too large. Please use a photo under 6MB.</div>';
      return;
    }
    selectedFile = file;
    const url = URL.createObjectURL(file);
    preview.src = url;
    preview.style.display = 'block';
    resultBox.innerHTML = '';
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!selectedFile) {
      resultBox.innerHTML = '<div class="alert alert-danger">Please attach a plant or leaf photo first.</div>';
      return;
    }

    const fd = new FormData();
    fd.append('image', selectedFile);
    fd.append('description', document.getElementById('plantDescription').value.trim());
    fd.append('language', AgriSeed.getLanguage());

    submitBtn.disabled = true;
    resultBox.innerHTML = '<div class="loading-row"><span class="spinner"></span> Examining the photo…</div>';

    try {
      const res = await fetch('backend/image-analysis.php', { method: 'POST', body: fd });
      const data = await res.json();
      if (!res.ok || data.success === false) {
        throw new Error(data.error || 'Plant Doctor is temporarily unavailable. Please try again.');
      }
      renderResult(data);
    } catch (err) {
      resultBox.innerHTML = `<div class="alert alert-danger">${escapeHtml(err.message)}</div>`;
    } finally {
      submitBtn.disabled = false;
    }
  });

  function renderResult(data) {
    const a = data.analysis || {};
    const rows = [
      ['Plant', a.plant],
      ['Possible issue', a.possible_issue],
      ['Visible symptoms', a.visible_symptoms],
      ['Possible causes', a.possible_causes],
      ['Recommended actions', a.recommended_actions],
      ['Prevention', a.prevention],
      ['Confidence', a.confidence],
    ];
    const hasStructured = rows.some(r => r[1]);
    let html = '<div class="card">';
    if (hasStructured) {
      rows.forEach(([label, value]) => {
        if (!value) return;
        html += `<div class="result-block"><div class="label">${label}</div><div>${escapeHtml(value)}</div></div>`;
      });
    } else {
      html += `<div style="white-space:pre-wrap;">${escapeHtml(data.raw || '')}</div>`;
    }
    html += `</div><div class="alert alert-info" style="margin-top:1rem;">${escapeHtml(data.disclaimer || '')}</div>`;
    resultBox.innerHTML = html;
  }

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }
});
