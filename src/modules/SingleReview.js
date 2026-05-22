export function singleReview() {
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
        reviewEndVisible = entry.isIntersecting;
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
};