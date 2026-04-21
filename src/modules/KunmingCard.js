export function kunmingCard() {
  if (!document.querySelector('.card-kunming, .card-suzhou')) return;

  document.addEventListener('click', (e) => {
    const toggle = e.target.closest('.card-kunming__details-toggle, .card-suzhou__details-toggle');
    if (!toggle) return;

    const infoBoxes = toggle.closest('.card-kunming__info-boxes, .card-suzhou__info-boxes');
    const content = infoBoxes?.querySelector('.card-kunming__details-content, .card-suzhou__details-content');
    if (!content) return;

    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!expanded));
    content.classList.toggle('expanded');
    const icon = toggle.querySelector('.toggle-icon svg');
    if (icon) icon.classList.toggle('rotated');
  });
}
