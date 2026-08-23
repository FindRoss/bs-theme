export default class AzIndex {
  constructor(root) {
    this.root = root;
    if (!this.root) return;

    this.searchInput  = this.root.querySelector('.az-index__search');
    this.sortBtns     = this.root.querySelectorAll('.az-index__sort-btn');
    this.alphaView    = this.root.querySelector('.az-index__view--alpha');
    this.popularView  = this.root.querySelector('.az-index__view--popular');
    this.items        = this.root.querySelectorAll('.az-index__item');
    this.groups       = this.root.querySelectorAll('.az-index__group');
    this.letterLinks  = this.root.querySelectorAll('.az-index__letter[href]');
    this.emptyState   = this.root.querySelector('.az-index__empty');
    this.emptyQuery   = this.root.querySelector('.az-index__empty-query');
    this.clearSearch  = this.root.querySelector('.az-index__clear-search');

    if (!this.searchInput || !this.alphaView || !this.popularView) return;

    this.sort = 'alpha';

    this.searchInput.addEventListener('input', () => this.filter());

    this.sortBtns.forEach(btn => {
      btn.addEventListener('click', () => this.setSort(btn.dataset.sort));
    });

    this.letterLinks.forEach(link => {
      link.addEventListener('click', e => this.handleLetterClick(e, link));
    });

    if (this.clearSearch) {
      this.clearSearch.addEventListener('click', e => {
        e.preventDefault();
        this.searchInput.value = '';
        this.filter();
        this.searchInput.focus();
      });
    }
  }

  filter() {
    const query = this.searchInput.value.trim().toLowerCase();

    this.items.forEach(item => {
      const matches = !query || item.dataset.name.includes(query);
      item.classList.toggle('is-hidden', !matches);
    });

    let visibleTotal = 0;

    this.groups.forEach(group => {
      const visibleItems = group.querySelectorAll('.az-index__item:not(.is-hidden)').length;
      group.classList.toggle('is-hidden', visibleItems === 0);
      visibleTotal += visibleItems;

      const letter = group.id.split('-').pop();
      const letterEl = this.root.querySelector(`.az-index__letter[data-letter="${letter === 'num' ? '#' : letter.toUpperCase()}"]`);
      if (letterEl && letterEl.hasAttribute('href')) {
        letterEl.classList.toggle('is-disabled', visibleItems === 0);
      }
    });

    const isEmpty = visibleTotal === 0;
    if (this.emptyState) this.emptyState.hidden = !isEmpty;
    if (this.emptyQuery) this.emptyQuery.textContent = this.searchInput.value.trim();
  }

  setSort(sort) {
    if (sort === this.sort) return;
    this.sort = sort;

    this.sortBtns.forEach(btn => btn.classList.toggle('is-active', btn.dataset.sort === sort));

    this.alphaView.hidden = sort !== 'alpha';
    this.popularView.hidden = sort !== 'popular';
  }

  handleLetterClick(e, link) {
    if (link.classList.contains('is-disabled')) {
      e.preventDefault();
      return;
    }

    if (this.sort !== 'popular') return;

    e.preventDefault();
    const targetId = link.getAttribute('href').slice(1);
    this.setSort('alpha');

    requestAnimationFrame(() => {
      const target = document.getElementById(targetId);
      if (!target) return;
      const rect = target.getBoundingClientRect();
      window.scrollTo({ top: rect.top + window.scrollY - 20, behavior: 'smooth' });
    });
  }
}
