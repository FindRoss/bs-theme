export function desktopMenu() {
  const desktopMenu = document.querySelector('.desktop-menu');
  const menuItemsWithChildren = desktopMenu.querySelectorAll('.menu-item-has-children');
  const subMenuWrappers = desktopMenu.querySelectorAll('.sub-menu-wrapper');

  function closeAllMenus() {
    subMenuWrappers.forEach((subMenu) => { subMenu.classList.remove('open') });
  }

  menuItemsWithChildren.forEach((menuItem) => {
    let closeTimeout;

    // Mouseenter 
    menuItem.addEventListener('mouseenter', (e) => {
      const subMenuWrapper = menuItem.querySelector('.sub-menu-wrapper');

      // Cancel any pending close actions
      clearTimeout(closeTimeout);

      openTimeout = setTimeout(() => {
        closeAllMenus();
        if (subMenuWrapper) {
          subMenuWrapper.classList.add('open');
        }
      }, 250);
    });


    // Mouseleave
    menuItem.addEventListener('mouseleave', (e) => {
      const subMenuWrapper = menuItem.querySelector('.sub-menu-wrapper');



      closeTimeout = setTimeout(() => {
        closeAllMenus();
        if (subMenuWrapper) {
          subMenuWrapper.classList.remove('open');
        }
      }, 250);
    });

  });
};