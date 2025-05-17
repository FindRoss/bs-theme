export function desktopMenu() {
  const desktopMenu = document.querySelector('.desktop-menu');
  const menuItemsWithChildren = desktopMenu.querySelectorAll('.menu-item-has-children');
  const subMenuWrappers = desktopMenu.querySelectorAll('.sub-menu-wrapper');

  function closeAllMenus() {
    subMenuWrappers.forEach((subMenu) => {
      subMenu.classList.remove('open');
    });
  }

  menuItemsWithChildren.forEach((menuItem) => {
    let openTimeout;   // ✅ define both timeouts here
    let closeTimeout;

    menuItem.addEventListener('mouseenter', () => {
      const subMenuWrapper = menuItem.querySelector('.sub-menu-wrapper');

      clearTimeout(closeTimeout); // Cancel any closing
      clearTimeout(openTimeout);  // ✅ Cancel previously scheduled opens

      openTimeout = setTimeout(() => {
        closeAllMenus();
        if (subMenuWrapper) {
          subMenuWrapper.classList.add('open');
        }
      }, 200);
    });

    menuItem.addEventListener('mouseleave', () => {
      const subMenuWrapper = menuItem.querySelector('.sub-menu-wrapper');

      clearTimeout(openTimeout); // ✅ Prevent menu from opening if not yet opened

      closeTimeout = setTimeout(() => {
        closeAllMenus();
        if (subMenuWrapper) {
          subMenuWrapper.classList.remove('open');
        }
      }, 50);
    });
  });
}
