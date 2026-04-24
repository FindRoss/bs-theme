import feather from 'feather-icons';
import { processExpiryPills } from './ExpiryDates';

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
    this.origin     = window.location.origin;

    this.button.addEventListener('click', () => this.handleClick());
  }

  async handleClick() {
    const page = parseInt(this.button.dataset.page, 10);

    this.button.querySelector('span').textContent = 'Loading…';
    this.button.disabled = true;

    try {
      const params = new URLSearchParams({
        taxonomy: this.taxonomy,
        term:     this.term,
        page,
      });

      const response = await fetch(`${this.origin}/wp-json/${this.endpoint}?${params.toString()}`);
      const data = await response.json();
      const { html, currentPage, totalPages } = data;

      const fragment = document.createRange().createContextualFragment(html);
      this.cardList.appendChild(fragment);

      feather.replace();
      processExpiryPills(this.cardList.querySelectorAll('.info-pill-expiry:not([data-expiry-done])'));

      if (currentPage >= totalPages) {
        this.button.closest('.km-load-more-wrapper').remove();
      } else {
        this.button.dataset.page = currentPage + 1;
        this.button.querySelector('span').textContent = 'Load More';
        this.button.disabled = false;
      }
    } catch (error) {
      this.button.querySelector('span').textContent = 'Load More';
      this.button.disabled = false;
    }
  }
}

export default TaxonomyLoadMore;
