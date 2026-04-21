export default class ArchiveReview {
  constructor() {
    this.searchInput = document.querySelector('#review-search');
    this.filterBtns  = document.querySelectorAll('.review-filter-btn');
    this.list        = document.querySelector('#review-archive-list');
    this.pagination  = document.querySelector('#review-pagination');

    if (!this.searchInput || !this.list) return;

    this.originalHTML    = this.list.innerHTML;
    this.originalPagHTML = this.pagination ? this.pagination.innerHTML : '';
    this.activeSlug      = '';
    this.debounceTimer   = null;
    this.apiBase         = `${window.location.origin}/wp-json/chaser/v2/reviews/search`;

    this.searchInput.addEventListener('input', () => this.handleChange());

    this.filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        this.filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        this.activeSlug = btn.dataset.slug;
        this.handleChange();
      });
    });
  }

  handleChange() {
    clearTimeout(this.debounceTimer);
    this.debounceTimer = setTimeout(() => this.fetch(), 300);
  }

  async fetch() {
    const q = this.searchInput.value.trim();

    if (!q && !this.activeSlug) {
      this.restore();
      return;
    }

    this.list.classList.add('is-loading');

    const params = new URLSearchParams();
    if (q)               params.set('q', q);
    if (this.activeSlug) params.set('review_type', this.activeSlug);

    try {
      const res  = await fetch(`${this.apiBase}?${params}`);
      const data = await res.json();

      this.list.classList.remove('is-loading');

      if (!data.html || data.count === 0) {
        this.list.innerHTML = '<p class="review-archive-no-results">No reviews found.</p>';
      } else {
        this.list.innerHTML = data.html;
      }

      if (this.pagination) this.pagination.innerHTML = '';

      if (window.feather) window.feather.replace();

    } catch (e) {
      this.list.classList.remove('is-loading');
    }
  }

  restore() {
    this.list.innerHTML = this.originalHTML;
    if (this.pagination) this.pagination.innerHTML = this.originalPagHTML;
    if (window.feather) window.feather.replace();
  }
}
