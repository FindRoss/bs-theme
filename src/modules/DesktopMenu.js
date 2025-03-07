export function desktopMenu() {
  const desktopMenu = document.querySelector('.desktop-menu');
  const menuItems = desktopMenu.querySelectorAll('.menu-item-has-children');
  const subMenuWrappers = desktopMenu.querySelectorAll('.sub-menu-wrapper');

  function closeAllMenus() {
    subMenuWrappers.forEach((subMenu) => { subMenu.classList.remove('open') });
  }

  menuItems.forEach((menuItem) => {

    // Close first level menu when mouse leaves
    menuItem.addEventListener('mouseleave', (e) => {
      const subMenuWrapper = menuItem.querySelector('.sub-menu-wrapper');
      closeAllMenus();
      if (subMenuWrapper) {
        subMenuWrapper.classList.remove('foobar');
      }
    });

    // Open menu on mouese enter
    menuItem.addEventListener('mouseenter', (e) => {
      const subMenuWrapper = menuItem.querySelector('.sub-menu-wrapper');
      console.log('fooooooooooooo');

      // Close all other menus here first? 
      closeAllMenus();

      if (subMenuWrapper) {
        subMenuWrapper.classList.add('open');
      }
    });

  });
};