class SidebarMenu {
  constructor() {
    this.body = document.querySelector('body')
    this.pageOverlay = document.querySelector('.page-overlay')
    this.navToggleBtn = document.querySelector('#nav-toggle')
    this.menuOpen = false
    this.drawer = document.querySelector('.background-drawer')
    this.sidebarMenu = document.querySelector('#menu-sidebar-nav')
    this.menuParentItems = this.sidebarMenu.querySelectorAll('.menu-item-has-children > a')
    this.allMenuLinks = this.sidebarMenu.querySelectorAll('a')

    this.searchToggleBtn = document.querySelector('#nav-search-btn')
    this.searchInput = document.querySelector('.nav-search-input')

    this.init()
  }

  init() {



    this.menuParentItems.forEach(item => {

      item.addEventListener('click', (e) => {
        e.preventDefault();

        const subMenu = item.nextElementSibling;
        if (!subMenu.classList.contains('active')) {
          subMenu.classList.add('active')
          item.classList.add('rotate')
        } else {
          subMenu.classList.remove('active');
          item.classList.remove('rotate')
        }
      })

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