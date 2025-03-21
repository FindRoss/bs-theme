export function singleReview() {
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

  const galleryOverlay = document.querySelector('#gallery-overlay');
  const closeOverlay = galleryOverlay.querySelector('#close-overlay');
  const galleryImages = document.querySelectorAll('.gallery-item');
  const mainGalleryImage = document.querySelector('#gallery-overlay-image');
  const bodyEl = document.querySelector('body');

  const overlayGalleryImages = galleryOverlay.querySelectorAll('.gallery-item');

  galleryImages.forEach((image) => {
    image.addEventListener('click', () => {
      galleryOverlay.classList.add('active');
      bodyEl.classList.add('no-scroll');


      const imageSrc = image.dataset.source;
      mainGalleryImage.src = imageSrc;

      overlayGalleryImages.forEach((overlayImage) => {
        overlayImage.classList.remove('active');
        if (overlayImage.dataset.source === imageSrc) {
          overlayImage.classList.add('active');
        }
      });

    });
  });

  closeOverlay.addEventListener('click', () => {
    galleryOverlay.classList.remove('active');
    bodyEl.classList.remove('no-scroll');
  });

};