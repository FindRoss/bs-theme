export function singleReview() {
  // Truncated chip lists — "Show all / Show fewer" toggle
  document.querySelectorAll('[data-truncated]').forEach(block => {
    const btn = block.querySelector('.truncated__toggle');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const open = block.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      btn.textContent = open ? btn.dataset.labelClose : btn.dataset.labelOpen;
    });
  });

  // Tab switching
  const tabBtns = document.querySelectorAll('.review-tabs__btn');
  const tabPanels = document.querySelectorAll('.review-tabs__panel');

  tabBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      tabBtns.forEach((b) => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
      tabPanels.forEach((p) => p.classList.remove('active'));
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');
      document.getElementById(btn.dataset.tab).classList.add('active');
    });
  });

  const contentDropdowns = document.querySelectorAll('.content-dropdown');

  contentDropdowns.forEach((dropdown) => {
    const control = dropdown.querySelector('.content-dropdown__controls');

    control.addEventListener('click', () => {
      const icon = control.querySelector('svg');
      icon.classList.toggle('rotated');
      const content = control.nextElementSibling;
      content.classList.toggle('expanded');
    });
  });

  // Mobile sticky bottom bar — appears when the inline mobile CTA scrolls out of view.
  // Desktop uses CSS position:sticky on .review-layout__cta instead.
  const stickyCta = document.querySelector('.sticky-cta');
  if (stickyCta) {
    const ctaColumn = document.querySelector('.review-layout__cta-mobile');
    const reviewEnd = document.getElementById('review-end-sentinel');

    let ctaOut = false;
    let reviewEndVisible = false;

    function updateStickyCta() {
      if (ctaOut && !reviewEndVisible) {
        stickyCta.classList.add('visible');
        stickyCta.removeAttribute('aria-hidden');
      } else {
        stickyCta.classList.remove('visible');
        stickyCta.setAttribute('aria-hidden', 'true');
      }
    }

    if (ctaColumn) {
      new IntersectionObserver(([entry]) => {
        ctaOut = !entry.isIntersecting;
        updateStickyCta();
      }, { threshold: 0 }).observe(ctaColumn);
    }

    if (reviewEnd) {
      new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
          reviewEndVisible = true;
        } else {
          // top < 0 means sentinel exited above the viewport (already scrolled past)
          reviewEndVisible = entry.boundingClientRect.top < 0;
        }
        updateStickyCta();
      }, { threshold: 0 }).observe(reviewEnd);
    }
  }

  // Rail CTA — hide while the hero CTA is visible in the header
  const heroCta = document.getElementById('hero-cta');
  const railCta = document.getElementById('rail-cta');
  if (heroCta && railCta) {
    new IntersectionObserver(
      ([entry]) => railCta.classList.toggle('is-hidden', entry.isIntersecting),
      { rootMargin: '-80px 0px 0px 0px', threshold: 0 }
    ).observe(heroCta);
  }

  // Trust index info tooltips
  const infoBtns = document.querySelectorAll('.review-trust-index__info-btn');
  infoBtns.forEach(btn => {
    btn.addEventListener('click', e => {
      e.stopPropagation();
      const isOpen = btn.getAttribute('aria-expanded') === 'true';
      infoBtns.forEach(b => b.setAttribute('aria-expanded', 'false'));
      if (!isOpen) btn.setAttribute('aria-expanded', 'true');
    });
  });
  if (infoBtns.length) {
    document.addEventListener('click', () => {
      infoBtns.forEach(b => b.setAttribute('aria-expanded', 'false'));
    });
  }

  // TOC scroll spy — highlights the link whose section is in the middle viewport band
  const tocLinks = [...document.querySelectorAll('.review-toc__link')];
  if (tocLinks.length) {
    const map = new Map();
    tocLinks.forEach(a => {
      const target = document.getElementById(a.getAttribute('href').slice(1));
      if (target) map.set(target, a);
    });

    if (map.size) {
      const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (!e.isIntersecting) return;
          tocLinks.forEach(l => l.classList.remove('is-active'));
          map.get(e.target)?.classList.add('is-active');
        });
      }, { rootMargin: '-30% 0px -60% 0px', threshold: 0 });

      map.forEach((_, el) => io.observe(el));
    }
  }
};