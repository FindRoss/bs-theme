class ShowMore {
  constructor() {
    this.showMoreLists = document.querySelectorAll('.show-more-list')
    this.event()
  }

  event() {
    console.log('showMoreLists', this.showMoreLists);
    this.showMoreLists.forEach((list) => {
      const btn = list.querySelector('#expand-review-list');
      const chevron = btn.querySelector('svg');
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