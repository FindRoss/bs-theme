class ShowMore {
  constructor() {
    this.showMoreLists = document.querySelectorAll('.show-more-list')
    this.event()
  }


  event() {
    this.showMoreLists.forEach((list) => {
      const btn = list.querySelector('#expand-review-list');
      const items = list.querySelectorAll('li.list-item-hidden');
      let isOpen = false;

      btn.addEventListener('click', () => {
        isOpen = !isOpen;
        items.forEach((item) => {
          item.classList.toggle('reveal');
        });
        btn.textContent = isOpen ? '-' : '+';
      });
    });
  }

}

export default ShowMore;