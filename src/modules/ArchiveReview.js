import feather from 'feather-icons';

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
    this.currentPage     = 1;
    this.debounceTimer   = null;
    this.apiBase         = `${window.location.origin}/wp-json/chaser/v2/reviews/search`;

    this.searchInput.addEventListener('input', () => {
      this.currentPage = 1;
      this.handleChange();
    });

    this.filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        this.filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        this.activeSlug  = btn.dataset.slug;
        this.currentPage = 1;
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
    params.set('page', this.currentPage);

    try {
      const res  = await fetch(`${this.apiBase}?${params}`);
      const data = await res.json();

      this.list.classList.remove('is-loading');

      if (!data.html || data.count === 0) {
        this.list.innerHTML = '<p class="review-archive-no-results">No reviews found.</p>';
      } else {
        this.list.innerHTML = data.html;
      }

      this.renderPagination(data);

      feather.replace();

    } catch (e) {
      this.list.classList.remove('is-loading');
    }
  }

  renderPagination({ paginationHtml }) {
    if (!this.pagination) return;

    this.pagination.innerHTML = paginationHtml || '';

    this.pagination.querySelectorAll('a.page-numbers').forEach(a => {
      a.addEventListener('click', e => {
        e.preventDefault();
        const url = new URL(a.href, window.location.href);
        this.currentPage = parseInt(url.searchParams.get('paged'), 10) || 1;
        this.fetch();
        window.scrollTo({ top: this.list.offsetTop - 20, behavior: 'smooth' });
      });
    });
  }

  restore() {
    this.list.innerHTML = this.originalHTML;
    if (this.pagination) this.pagination.innerHTML = this.originalPagHTML;
    feather.replace();
  }
}
