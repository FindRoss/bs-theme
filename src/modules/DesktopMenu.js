export function desktopMenu() {
  const desktopMenu = document.querySelector('.desktop-menu');
  const menuItemsWithChildren = desktopMenu.querySelectorAll('.menu-item-has-children');
  const subMenuWrappers = desktopMenu.querySelectorAll('.sub-menu-wrapper');
  const overlay = document.querySelector('.page-overlay');

  function closeAllMenus() {
    subMenuWrappers.forEach((subMenu) => {
      subMenu.classList.remove('open');
    });
    overlay?.classList.remove('active');
  }

  menuItemsWithChildren.forEach((menuItem) => {
    let openTimeout;
    let closeTimeout;

    menuItem.addEventListener('mouseenter', () => {
      const subMenuWrapper = menuItem.querySelector('.sub-menu-wrapper');

      clearTimeout(closeTimeout);
      clearTimeout(openTimeout);

      openTimeout = setTimeout(() => {
        closeAllMenus();
        if (subMenuWrapper) {
          subMenuWrapper.classList.add('open');
          overlay?.classList.add('active');
        }
      }, 200);
    });

    menuItem.addEventListener('mouseleave', () => {
      clearTimeout(openTimeout);

      closeTimeout = setTimeout(() => {
        closeAllMenus();
      }, 50);
    });
  });
}
