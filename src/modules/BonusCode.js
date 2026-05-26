class BonusCode {
  constructor() {
    this.bonusCodeBtns = document.querySelectorAll('.bonus-code');
    this.events();
  }

  events() {
    if (this.bonusCodeBtns.length === 0) return;

    this.bonusCodeBtns.forEach(btn => {
      btn.addEventListener('click', e => {
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
    });
  }
}

export default BonusCode;
