class ToggleFilterModal {
  constructor() {
    this.filterOverlay = document.getElementById('filterOverlay');
    this.fitlerOverlayClose = document.getElementById('filterOverlayClose');
    this.filterBtn = document.getElementById('searchButtonFilter');
    this.filterModalOpen = false;
    this.filterItemHeadings = document.querySelectorAll('.filter-toggle');
    this.filterApplyBtn = document.getElementById('filterApplyBtn');

    this.init();
  }

  init() {
    this.filterBtn.addEventListener('click', () => this.openFilterModal());
    this.fitlerOverlayClose.addEventListener('click', () => this.closeFilterModal());
    [...this.filterItemHeadings].map(heading => heading.addEventListener('click', (event) => this.handleFilterHeadingClick(event)));
    this.filterApplyBtn.addEventListener('click', () => this.closeFilterModal());
  }

  openFilterModal() {
    this.filterOverlay.classList.remove('d-none');
    this.filterModalOpen = true;
    document.body.style.overflow = 'hidden'; // Disable scrolling
  }

  closeFilterModal() {
    this.filterOverlay.classList.add('d-none');
    this.filterModalOpen = false;
    document.body.style.overflow = 'auto';
  }

  handleFilterHeadingClick(event) {
    const clickedElement = event.currentTarget; // The element the event listener is attached to
    const checkboxWrapper = clickedElement.nextElementSibling;
    const icon = clickedElement.querySelector('.icon');

    if (checkboxWrapper && !checkboxWrapper.classList.contains('checkboxes-closed')) {
      checkboxWrapper.classList.add('checkboxes-closed');
      // icon.classList.remove('rotate');
      icon.classList.add('rotate');

    } else if (checkboxWrapper) {
      checkboxWrapper.classList.remove('checkboxes-closed');
      icon.classList.remove('rotate');
    }
  }

}

export default ToggleFilterModal; 