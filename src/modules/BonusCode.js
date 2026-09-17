class BonusCode {
  constructor() {
    this.events();
  }

  events() {
    document.addEventListener('click', e => {
      const btn = e.target.closest('.bonus-code');
      if (!btn) return;

      e.preventDefault();
      e.stopPropagation();

      const codeEl = btn.querySelector('.bonus-code__code');
      if (!codeEl) return;

      const code = codeEl.textContent.trim();
      try { navigator.clipboard?.writeText(code); } catch (_) {}

      const original = codeEl.textContent;
      codeEl.textContent = 'Copied!';
      btn.classList.add('copied');

      const liveEl = btn.querySelector('[aria-live]');
      if (liveEl) liveEl.textContent = 'Code copied';

      setTimeout(() => {
        btn.classList.remove('copied');
        codeEl.textContent = original;
        if (liveEl) liveEl.textContent = '';
      }, 1400);
    });
  }
}

export default BonusCode;
