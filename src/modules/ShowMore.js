class ShowMore {
  constructor() {
    this.showMoreLists = document.querySelectorAll('.show-more-list')
    this.event()
  }


  event() {
    this.showMoreLists.forEach((list) => {
      const btn = list.querySelector('#expand-review-list');
      const items = list.querySelectorAll('.term-list-item');

      btn.addEventListener('click', () => {
        items.forEach((item) => {
          item.classList.remove('visually-hidden');
          btn.classList.add('visually-hidden');
        });
      });
    });
  }

}

export default ShowMore;