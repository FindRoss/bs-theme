class ShowMore {
  lists: NodeListOf<Element>;

  constructor() {
    this.lists = document.querySelectorAll('.show-more-list')
    this.event()
  }

  event() {
    this.lists.forEach((list) => {
      const btn = list.querySelector('#expand-review-list');
      if (!btn) return;

      const chevron = btn.querySelector('svg');
      if (!chevron) return;

      const items = list.querySelectorAll('li.list-item-hidden');
      let isOpen = false;

      btn.addEventListener('click', () => {
        isOpen = !isOpen;
        items.forEach((item) => {
          item.classList.toggle('reveal');
        });

        isOpen ? chevron.classList.add('rotate') : chevron.classList.remove('rotate');
      });
    });
  }

}

export default ShowMore;