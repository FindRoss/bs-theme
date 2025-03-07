class SidebarMenu {
  constructor() {
    this.body = document.querySelector('body')
    this.pageOverlay = document.querySelector('.page-overlay')
    this.navToggleBtn = document.querySelector('#nav-toggle')
    this.menuOpen = false
    this.drawer = document.querySelector('.background-drawer')

    this.sidebarMenu = document.querySelector('#menu-sidebar-nav')
    this.menuListItems = this.sidebarMenu.querySelectorAll('.menu-item-has-children')
    this.menuParentItems = this.sidebarMenu.querySelectorAll('.menu-item-has-children > a')
    this.allMenuLinks = this.sidebarMenu.querySelectorAll('a')

    this.searchToggleBtn = document.querySelector('#nav-search-btn')
    this.searchInput = document.querySelector('.nav-search-input')

    this.init()
  }

  createChevronElement() {
    const chevronWrapper = document.createElement('div');
    chevronWrapper.classList.add('chevron-wrapper');
    const chevron = document.createElement('span');
    chevron.classList.add('chevron');
    chevronWrapper.appendChild(chevron);
    return chevronWrapper;
  }

  handleChevronClick(item) {
    const subMenu = item.querySelector('.sub-menu');
    const chevron = item.querySelector('.chevron-wrapper .chevron'); // Select the chevron

    if (!subMenu.classList.contains('active')) {
      subMenu.classList.add('active')
      chevron.classList.add('rotate') // Rotate the chevron

    } else {
      subMenu.classList.remove('active');
      chevron.classList.remove('rotate') // Unrotate the chevron
    }
  }

  init() {

    this.menuListItems.forEach(item => {
      const subMenu = item.querySelector('ul.sub-menu');
      if (!subMenu) return;

      const chevron = this.createChevronElement();
      item.insertBefore(chevron, subMenu);

      item.addEventListener('click', (e) => this.handleChevronClick(item));
    })

    this.searchToggleBtn.addEventListener('click', () => {
      this.menuOpen = !this.menuOpen

      this.toggleMenu()

      if (this.menuOpen == true) {
        this.searchInput.focus()
      }
    })

    this.navToggleBtn.addEventListener('click', () => {
      this.menuOpen = !this.menuOpen
      this.toggleMenu()
    });

    this.pageOverlay.addEventListener('click', () => {
      this.menuOpen = !this.menuOpen
      this.toggleMenu()
    });

    this.addClassToLinks()
  }

  addClassToLinks() {
    this.allMenuLinks.forEach(link => {
      if (link.href.includes('#')) return;

      link.classList.add('nav-link');
    })
  }

  toggleMenu() {
    if (this.menuOpen) {
      this.drawer.classList.add('show')
      this.body.classList.add('no-scroll')
      this.pageOverlay.classList.add('active')
      this.navToggleBtn.setAttribute('aria-label', 'Close menu')
      this.navToggleBtn.innerHTML = svgIcons.close;
    } else {
      this.drawer.classList.remove('show')
      this.body.classList.remove('no-scroll')
      this.pageOverlay.classList.remove('active')
      this.navToggleBtn.setAttribute('aria-label', 'Open menu')
      this.navToggleBtn.innerHTML = svgIcons.hamburger;
    }
    this.navToggleBtn.setAttribute('aria-expanded', this.menuOpen);
  }
}

export default SidebarMenu;