export function singleReview() {
  // Show More functionality

  // I need to make sure I am only on the single review page
  if (!document.querySelector('.single-review')) return;

  let groupContent = document.querySelectorAll('.wp-block-group');

  // groupedContent.forEach((group) => {
  //   console.log(group.firstElementChild.classList.contains('wp-block-heading'));
  // });

  // Filter groups to only those that have a heading as the first child
  let groupContentToToggle = Array.from(groupContent).filter((group) => {
    const firstChild = group.firstElementChild;

    // Check if the first child is a heading and has the class 'wp-block-heading'
    return (
      firstChild &&
      firstChild.classList.contains('wp-block-heading') &&
      firstChild.tagName.toLowerCase() === 'h3'
    );
  });

  // Add a click event listener to each heading
  groupContentToToggle.map((group) => {
    let heading = group.firstElementChild;
    heading.classList.add('toggle-heading');

    // Create a chevron icon element
    const iconButton = document.createElement('button');
    iconButton.classList.add('round-icon');
    iconButton.innerHTML = svgIcons.chevronDown;

    heading.appendChild(iconButton);

    // Group all the content inside one div
    const contentDiv = document.createElement('div');
    contentDiv.classList.add('toggle-heading-content');
    // Get all content after the heading and group it up

    // Get all siblings after the heading
    let sibling = heading.nextElementSibling;
    while (sibling) {
      const next = sibling.nextElementSibling; // Save reference before moving
      contentDiv.appendChild(sibling);
      sibling = next;
    }

    // Append the contentDiv to the group
    group.appendChild(contentDiv);

    heading.addEventListener('click', () => {
      console.log('Heading clicked:', heading.textContent);
      iconButton.classList.toggle('rotated');
      contentDiv.classList.toggle('expanded');
    });
  });



  // Gallery Overlay
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


  galleryOverlay.addEventListener('click', function (e) {
    // Check if the clicked element or its parents are NOT the content or footer
    const clickedContent = e.target.closest('.gallery-overlay-content');
    const clickedFooter = e.target.closest('.gallery-overlay-footer');

    // If neither content nor footer was clicked, close the overlay
    if (!clickedContent && !clickedFooter) {
      // Close the overlay
      galleryOverlay.classList.remove('active');
      bodyEl.classList.remove('no-scroll');
    }
  });


  closeOverlay.addEventListener('click', (e) => {
    e.stopPropagation(); // Stop the event from bubbling up to the overlay
    galleryOverlay.classList.remove('active');
    bodyEl.classList.remove('no-scroll');
  });

};