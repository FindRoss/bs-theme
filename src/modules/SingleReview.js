export function singleReview() {
  // content-dropdown
  const contentDropdowns = document.querySelectorAll('.content-dropdown');
  console.log('contentDropdowns ', contentDropdowns);

  contentDropdowns.forEach((dropdown) => {
    const control = dropdown.querySelector('.content-dropdown__controls');

    control.addEventListener('click', () => {
      const icon = control.querySelector('svg');
      icon.classList.toggle('rotated');
      const content = control.nextElementSibling;
      content.classList.toggle('expanded');
    });
  });

};