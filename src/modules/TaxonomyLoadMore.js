import feather from 'feather-icons';

class TaxonomyLoadMore {
  constructor() {
    this.cardList = document.getElementById('km-card-list');
    if (!this.cardList) return;

    this.button = document.querySelector('.km-load-more');
    if (!this.button) return;

    this.taxonomy   = this.cardList.dataset.taxonomy;
    this.term       = this.cardList.dataset.term;
    this.totalPages = parseInt(this.cardList.dataset.totalPages, 10);
    this.endpoint   = this.cardList.dataset.endpoint || 'chaser/v2/reviews';
    this.headingLevel = this.cardList.dataset.headingLevel;
    this.origin     = window.location.origin;

    // IDs mode: the page supplies the full ordered list, we request the next slice.
    this.ids     = this.cardList.dataset.ids ? this.cardList.dataset.ids.split(',') : null;
    this.shown   = parseInt(this.cardList.dataset.shown, 10) || 0;
    this.perPage = parseInt(this.cardList.dataset.perPage, 10) || 6;

    this.button.addEventListener('click', () => this.handleClick());
  }

  async handleClick() {
    this.button.querySelector('span').textContent = 'Loading…';
    this.button.disabled = true;

    try {
      const done = this.ids ? await this.loadNextIds() : await this.loadNextPage();

      feather.replace();

      if (done) {
        this.button.closest('.km-load-more-wrapper').remove();
      } else {
        this.button.querySelector('span').textContent = 'Load More';
        this.button.disabled = false;
      }
    } catch (error) {
      this.button.querySelector('span').textContent = 'Load More';
      this.button.disabled = false;
    }
  }

  async loadNextIds() {
    const next = this.ids.slice(this.shown, this.shown + this.perPage);
    const params = new URLSearchParams({ ids: next.join(',') });

    const response = await fetch(`${this.origin}/wp-json/${this.endpoint}?${params.toString()}`);
    const { html } = await response.json();

    this.append(html);
    this.shown += next.length;

    return this.shown >= this.ids.length;
  }

  async loadNextPage() {
    const page = parseInt(this.button.dataset.page, 10);
    const params = new URLSearchParams({
      taxonomy: this.taxonomy,
      term:     this.term,
      page,
    });
    if (this.headingLevel) params.set('heading_level', this.headingLevel);

    const response = await fetch(`${this.origin}/wp-json/${this.endpoint}?${params.toString()}`);
    const { html, currentPage, totalPages } = await response.json();

    this.append(html);
    this.button.dataset.page = currentPage + 1;

    return currentPage >= totalPages;
  }

  append(html) {
    const fragment = document.createRange().createContextualFragment(html);
    this.cardList.appendChild(fragment);
  }
}

export default TaxonomyLoadMore;
