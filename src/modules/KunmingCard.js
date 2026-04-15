export function kunmingCard() {
  if (!document.querySelector('.card-kunming')) return;

  document.addEventListener('click', (e) => {
    const toggle = e.target.closest('.card-kunming__details-toggle');
    if (!toggle) return;

    const content = toggle.closest('.card-kunming__info-boxes')
      ?.querySelector('.card-kunming__details-content');
    if (!content) return;

    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!expanded));
    content.classList.toggle('expanded');
    const icon = toggle.querySelector('.toggle-icon svg');
    if (icon) icon.classList.toggle('rotated');
  });
}
