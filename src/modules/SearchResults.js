import feather from 'feather-icons';

class SearchResults {
  constructor() {
    this.state = {
      term:   '',
      types:  new Set(),
      date:   'anytime',
      topics: new Set(),
      sort:   'relevance',
      page:   1,
    };

    this.els = {
      input:          document.getElementById('searchInput'),
      form:           document.getElementById('searchForm'),
      resultCount:    document.getElementById('searchResultCount'),
      resultsContainer: document.getElementById('searchResultsContainer'),
      pagination:     document.getElementById('searchPaginationContainer'),
      spinner:        document.getElementById('spinner'),
      activeFilters:  document.getElementById('activeFilters'),
      activeStrip:    document.getElementById('activeChipsStrip'),
      filterBadge:    document.getElementById('filterBadge'),
      filterOpenBtn:  document.getElementById('filterOpenBtn'),
      filterCloseBtn: document.getElementById('filterCloseBtn'),
      filterApplyBtn: document.getElementById('filterApplyBtn'),
      filterResetBtn: document.getElementById('filterResetBtn'),
      filterBackdrop: document.getElementById('filterBackdrop'),
      filterAside:    document.getElementById('searchFilter'),
      sortChip:       document.getElementById('sortChip'),
      sortDropdown:   document.getElementById('sortDropdown'),
      clearAll:       document.getElementById('clearAllFilters'),
    };

    this.hydrateFromUrl();
    this.syncInputDisplay();
    this.bindEvents();

    if (this.state.term) {
      this.fetch();
    } else {
      this.hideSpinner();
      this.renderEmpty();
    }
  }

  // ── URL / State ─────────────────────────────────────────────────────────────

  hydrateFromUrl() {
    const p = new URLSearchParams(window.location.search);
    this.state.term = this.sanitize(p.get('s') || '');

    const types = p.getAll('types[]');
    this.state.types = new Set(types.filter(t => ['post','review','bonus','streamer'].includes(t)));

    const date = p.get('date');
    this.state.date = ['anytime','last_month','last_year'].includes(date) ? date : 'anytime';

    const topics = p.getAll('topics[]');
    this.state.topics = new Set(topics);

    const sort = p.get('sort');
    this.state.sort = ['relevance','newest','oldest'].includes(sort) ? sort : 'relevance';

    this.state.page = Math.max(1, parseInt(p.get('page') || '1', 10) || 1);
  }

  pushUrl() {
    const p = new URLSearchParams();
    if (this.state.term) p.set('s', this.state.term);
    this.state.types.forEach(t => p.append('types[]', t));
    if (this.state.date !== 'anytime') p.set('date', this.state.date);
    this.state.topics.forEach(t => p.append('topics[]', t));
    if (this.state.sort !== 'relevance') p.set('sort', this.state.sort);
    if (this.state.page > 1) p.set('page', this.state.page);
    window.history.pushState({}, '', `?${p.toString()}`);
  }

  syncInputDisplay() {
    if (this.els.input) this.els.input.value = this.state.term;
  }

  // ── Events ──────────────────────────────────────────────────────────────────

  bindEvents() {
    // Search form
    this.els.form?.addEventListener('submit', e => {
      e.preventDefault();
      const val = this.sanitize(this.els.input.value.trim());
      if (!val) return;
      this.state.term = val;
      this.state.page = 1;
      this.pushUrl();
      this.refetch();
    });

    // Type filter rows
    document.querySelectorAll('[data-filter-type="type"]').forEach(btn => {
      btn.addEventListener('click', () => {
        const val = btn.dataset.value;
        this.state.types.has(val) ? this.state.types.delete(val) : this.state.types.add(val);
        this.state.page = 1;
        this.pushUrl();
        this.refetch();
      });
    });

    // Date filter rows
    document.querySelectorAll('[data-filter-type="date"]').forEach(btn => {
      btn.addEventListener('click', () => {
        this.state.date = btn.dataset.value;
        this.state.page = 1;
        this.pushUrl();
        this.refetch();
      });
    });

    // Sort chip + dropdown
    this.els.sortChip?.addEventListener('click', e => {
      e.stopPropagation();
      this.els.sortDropdown?.classList.toggle('d-none');
    });

    this.els.sortDropdown?.querySelectorAll('[data-sort]').forEach(btn => {
      btn.addEventListener('click', () => {
        this.state.sort = btn.dataset.sort;
        this.state.page = 1;
        this.pushUrl();
        this.updateSortChip();
        this.els.sortDropdown.classList.add('d-none');
        this.refetch();
      });
    });

    // Clear all
    this.els.clearAll?.addEventListener('click', () => {
      this.state.types  = new Set();
      this.state.date   = 'anytime';
      this.state.topics = new Set();
      this.state.page   = 1;
      this.pushUrl();
      this.refetch();
    });

    // Mobile drawer open/close
    this.els.filterOpenBtn?.addEventListener('click',    () => this.openDrawer());
    this.els.filterCloseBtn?.addEventListener('click',   () => this.closeDrawer());
    this.els.filterBackdrop?.addEventListener('click',   () => this.closeDrawer());
    this.els.filterApplyBtn?.addEventListener('click',   () => this.closeDrawer());
    this.els.filterResetBtn?.addEventListener('click',   () => {
      this.state.types  = new Set();
      this.state.date   = 'anytime';
      this.state.topics = new Set();
      this.state.page   = 1;
      this.pushUrl();
      this.updateFilterUI({});
      this.closeDrawer();
      this.refetch();
    });

    // Close dropdown on outside click / ESC
    document.addEventListener('click', () => this.els.sortDropdown?.classList.add('d-none'));
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        this.closeDrawer();
        this.els.sortDropdown?.classList.add('d-none');
      }
    });
  }

  openDrawer() {
    this.els.filterAside?.classList.add('is-open');
    this.els.filterBackdrop?.classList.remove('d-none');
    document.body.classList.add('no-scroll');
  }

  closeDrawer() {
    this.els.filterAside?.classList.remove('is-open');
    this.els.filterBackdrop?.classList.add('d-none');
    document.body.classList.remove('no-scroll');
  }

  // ── Fetch ────────────────────────────────────────────────────────────────────

  refetch() {
    this.clearResults();
    this.fetch();
  }

  buildParams() {
    const sortMap = {
      relevance: { order: 'DESC', orderby: 'relevance' },
      newest:    { order: 'DESC', orderby: 'date' },
      oldest:    { order: 'ASC',  orderby: 'date' },
    };
    const { order, orderby } = sortMap[this.state.sort] || sortMap.relevance;
    const typesArr  = this.state.types.size  ? JSON.stringify([...this.state.types])  : 'all';
    const topicsArr = JSON.stringify([...this.state.topics]);
    return new URLSearchParams({ term: this.state.term, types: typesArr, date: this.state.date, topics: topicsArr, order, orderby, page: this.state.page });
  }

  async fetch() {
    this.showSpinner();
    try {
      const res  = await fetch(`${location.origin}/wp-json/chaser/v2/search?${this.buildParams()}`);
      const data = await res.json();
      const { terms, results, counts, currentPage, totalPages, totalPosts } = data;

      this.state.page = currentPage;
      this.updateFilterUI(counts);
      this.updateSortChip();

      if (results.length > 0 || terms.length > 0) {
        this.renderTermCards(terms);
        this.renderResults(results, true);
        this.renderCount(totalPosts);
        this.renderPagination(currentPage, totalPages);
      } else {
        this.renderCount(0);
        this.renderEmpty();
      }
    } catch (_) {
      this.renderEmpty();
    } finally {
      this.hideSpinner();
    }
  }

  async fetchMore() {
    this.state.page++;
    this.showSpinner();
    try {
      const res  = await fetch(`${location.origin}/wp-json/chaser/v2/search?${this.buildParams()}`);
      const data = await res.json();
      this.renderResults(data.results, false);
      this.renderPagination(data.currentPage, data.totalPages);
    } catch (_) {
      // noop
    } finally {
      this.hideSpinner();
    }
  }

  // ── Render ───────────────────────────────────────────────────────────────────

  renderTermCards(terms) {
    const existing = document.getElementById('topicResultsSection');
    if (existing) existing.remove();
    if (!terms || !terms.length) return;

    const cards = terms.map(t => `
      <div class="result-card">
        <a class="result-card__link" href="${t.link}">
          <div class="result-thumb">
            ${t.image ? `<img src="${t.image}" alt="" width="110" height="76" loading="lazy">` : '<div class="result-thumb-placeholder"></div>'}
          </div>
          <div class="result-body">
            <span class="result-pill result-pill--topic">Topic</span>
            <div class="result-title">${t.title}</div>
            <div class="result-excerpt">Browse all Reviews tagged ${t.title}</div>
          </div>
        </a>
      </div>
      <div class="result-divider"></div>`).join('');

    const section = document.createElement('div');
    section.id = 'topicResultsSection';
    section.innerHTML = cards;
    this.els.resultsContainer.before(section);
  }

  renderResults(results, replace) {
    const html = results.map(r => this.cardHTML(r)).join('');
    if (replace) {
      this.els.resultsContainer.innerHTML = html;
    } else {
      this.els.resultsContainer.insertAdjacentHTML('beforeend', html);
    }
  }

  cardHTML(r) {
    const isBonus = r.postType === 'bonus';
    const thumb = r.image
      ? `<img src="${r.image}" alt="" width="110" height="76" loading="lazy">`
      : `<div class="result-thumb-placeholder"></div>`;
    const pill = `<span class="result-pill result-pill--${r.postType}">${r.label || r.postType}</span>`;
    const cardClass = isBonus ? 'result-card result-card--bonus' : 'result-card';

    return `
      <div class="${cardClass}">
        <a class="result-card__link" href="${r.link}">
          <div class="result-thumb">${thumb}</div>
          <div class="result-body">
            ${pill}
            <div class="result-title">${r.title}</div>
            ${r.excerpt ? `<div class="result-excerpt">${r.excerpt}</div>` : ''}
          </div>
        </a>
      </div>
      <div class="result-divider"></div>`;
  }

  renderCount(total) {
    if (this.els.resultCount) {
      this.els.resultCount.textContent = total > 0 ? `${total} results` : '';
    }
  }

  renderEmpty() {
    this.els.resultsContainer.innerHTML = `
      <div class="search-empty">
        <div class="search-empty__eyebrow">NO RESULTS FOR</div>
        <div class="search-empty__query">"${this.state.term}"</div>
        <p class="search-empty__note">Couldn't find anything matching your search.</p>
      </div>`;
    this.els.pagination.innerHTML = '';
  }

  renderPagination(page, totalPages) {
    if (!totalPages || page >= totalPages) { this.els.pagination.innerHTML = ''; return; }
    const wrap = document.createElement('div');
    wrap.className = 'd-flex justify-content-center';
    const btn = document.createElement('button');
    btn.className = 'button button__primary';
    btn.textContent = 'Load More';
    btn.addEventListener('click', async () => {
      btn.textContent = 'Loading…';
      btn.disabled = true;
      await this.fetchMore();
    });
    wrap.appendChild(btn);
    this.els.pagination.replaceChildren(wrap);
  }

  clearResults() {
    this.els.resultsContainer.innerHTML = '';
    this.els.pagination.innerHTML = '';
    if (this.els.resultCount) this.els.resultCount.textContent = '';
  }

  // ── Filter UI ────────────────────────────────────────────────────────────────

  updateFilterUI(counts) {
    // Type rows
    document.querySelectorAll('[data-filter-type="type"]').forEach(btn => {
      const val     = btn.dataset.value;
      const isActive = this.state.types.has(val);
      const count   = counts ? (counts[val] ?? null) : null;
      btn.classList.toggle('is-active', isActive);
      const dot = btn.querySelector('.filter-row__dot');
      if (dot) dot.textContent = isActive ? '◉' : '◯';
      const countEl = btn.querySelector('.filter-row__count');
      if (countEl && count !== null) countEl.textContent = count;
      const isZero = count === 0 && !isActive;
      btn.classList.toggle('is-zero', isZero);
      btn.disabled = isZero;
    });

    // Date rows
    document.querySelectorAll('[data-filter-type="date"]').forEach(btn => {
      const isActive = this.state.date === btn.dataset.value;
      btn.classList.toggle('is-active', isActive);
      const dot = btn.querySelector('.filter-row__dot');
      if (dot) dot.textContent = isActive ? '◉' : '◯';
    });

    this.renderActiveChips();
    this.updateFilterBadge();
  }

  updateFilterBadge() {
    const count = this.state.types.size + this.state.topics.size + (this.state.date !== 'anytime' ? 1 : 0);
    if (this.els.filterBadge) {
      this.els.filterBadge.textContent = count;
      this.els.filterBadge.classList.toggle('d-none', count === 0);
    }
  }

  renderActiveChips() {
    const typeLabels = { post: 'Articles', review: 'Reviews', bonus: 'Bonuses', streamer: 'Streamers' };
    const dateLabels = { last_month: 'Last month', last_year: 'Last year' };
    const chips = [];

    this.state.types.forEach(t => chips.push({
      label: typeLabels[t] || t,
      remove: () => { this.state.types.delete(t); this.state.page = 1; this.pushUrl(); this.refetch(); },
    }));

    if (this.state.date !== 'anytime') chips.push({
      label: dateLabels[this.state.date] || this.state.date,
      remove: () => { this.state.date = 'anytime'; this.state.page = 1; this.pushUrl(); this.refetch(); },
    });

    this.state.topics.forEach(t => chips.push({
      label: t,
      remove: () => { this.state.topics.delete(t); this.state.page = 1; this.pushUrl(); this.refetch(); },
    }));

    const build = container => {
      if (!container) return;
      if (!chips.length) { container.innerHTML = ''; return; }
      container.innerHTML = `<span class="active-label">ACTIVE:</span>` +
        chips.map((c, i) => `<button class="active-chip" data-i="${i}" type="button">${c.label} ✕</button>`).join('');
      container.querySelectorAll('.active-chip').forEach(btn =>
        btn.addEventListener('click', () => chips[+btn.dataset.i].remove())
      );
    };

    build(this.els.activeFilters);
    build(this.els.activeStrip);
  }

  updateSortChip() {
    const labels = { relevance: 'Relevance', newest: 'Newest', oldest: 'Oldest' };
    const label  = labels[this.state.sort] || 'Relevance';
    if (this.els.sortChip) {
      this.els.sortChip.innerHTML = `${label} <i data-feather="chevron-down"></i>`;
      feather.replace({ 'stroke-width': 2 });
    }
  }

  // ── Spinner ──────────────────────────────────────────────────────────────────

  showSpinner() { this.els.spinner?.classList.remove('d-none'); }
  hideSpinner() { this.els.spinner?.classList.add('d-none'); }

  // ── Util ─────────────────────────────────────────────────────────────────────

  sanitize(input) {
    return input.replace(/[<>"'&]/g, '').trim().substring(0, 150);
  }
}

export default SearchResults;
