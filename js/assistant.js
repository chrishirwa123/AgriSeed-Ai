document.addEventListener('DOMContentLoaded', () => {
  const log = document.getElementById('chatLog');
  const form = document.getElementById('chatForm');
  const input = document.getElementById('chatInput');
  const clearBtn = document.getElementById('clearChatBtn');
  const sendBtn = document.getElementById('sendBtn');

  const HISTORY_KEY = 'agriseed_chat_history';
  let history = loadHistory();

  function loadHistory() {
    try {
      const raw = sessionStorage.getItem(HISTORY_KEY);
      return raw ? JSON.parse(raw) : [];
    } catch { return []; }
  }

  function saveHistory() {
    sessionStorage.setItem(HISTORY_KEY, JSON.stringify(history.slice(-16)));
  }

  function addMessage(role, text) {
    const wrap = document.createElement('div');
    wrap.className = `msg ${role === 'user' ? 'msg-user' : 'msg-ai'}`;
    wrap.innerHTML = `
      <div class="msg-avatar">${role === 'user' ? '🧑‍🌾' : '🌱'}</div>
      <div class="msg-bubble"></div>`;
    wrap.querySelector('.msg-bubble').textContent = text;
    log.appendChild(wrap);
    log.scrollTop = log.scrollHeight;
    return wrap;
  }

  function renderHistory() {
    log.innerHTML = '';
    if (history.length === 0) {
      addMessage('ai', 'Hello! I\'m AgriSeed AI. Ask me anything about crops, soil, pests, irrigation, or what to plant this season.');
      return;
    }
    history.forEach(m => addMessage(m.role, m.content));
  }

  async function sendMessage(text) {
    addMessage('user', text);
    history.push({ role: 'user', content: text });
    saveHistory();
    input.value = '';
    sendBtn.disabled = true;

    const typingEl = addMessage('ai', '…thinking');

    const loc = AgriSeed.getLocation();
    const weather = AgriSeed.getWeather();
    const context = {};
    if (loc && loc.label) context.locationLabel = loc.label;
    if (weather && weather.available) {
      context.weatherSummary = `${Math.round(weather.temperature)}°C, ${weather.condition}, humidity ${weather.humidity}%`;
    }

    try {
      const data = await AgriSeed.postJSON('backend/ai.php', {
        mode: 'chat',
        message: text,
        history: history.slice(0, -1).slice(-10),
        language: AgriSeed.getLanguage(),
        context,
      });
      typingEl.querySelector('.msg-bubble').textContent = data.reply;
      history.push({ role: 'assistant', content: data.reply });
      saveHistory();
    } catch (e) {
      typingEl.querySelector('.msg-bubble').textContent = e.message || 'AgriSeed AI is temporarily unavailable. Please try again.';
      typingEl.querySelector('.msg-bubble').style.color = 'var(--color-danger)';
    } finally {
      sendBtn.disabled = false;
      input.focus();
    }
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const text = input.value.trim();
    if (!text) return;
    sendMessage(text);
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      form.requestSubmit();
    }
  });

  clearBtn.addEventListener('click', () => {
    history = [];
    saveHistory();
    renderHistory();
  });

  renderHistory();
});
