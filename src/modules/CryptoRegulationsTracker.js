class CryptoRegulationsTracker {
  constructor() {
    this.root = document.querySelector('#crypto-regs-tracker');
    if (!this.root) return;

    this.searchInput = this.root.querySelector('#crypto-regs-search');
    this.statusChips = this.root.querySelectorAll('[data-chip-group="status"] .crypto-regs__chip');
    this.regionChips = this.root.querySelectorAll('[data-chip-group="region"] .crypto-regs__chip');
    this.groups = this.root.querySelectorAll('.crypto-regs__group');
    this.resultCountEl = this.root.querySelector('#crypto-regs-count');
    this.emptyEl = this.root.querySelector('#crypto-regs-empty');
    this.resetButtons = this.root.querySelectorAll('[data-reset]');

    this.state = { query: '', status: 'all', region: 'all' };

    this.bindEvents();
    this.applyFilters();
  }

  bindEvents() {
    if (this.searchInput) {
      this.searchInput.addEventListener('input', (e) => {
        this.state.query = e.target.value.trim().toLowerCase();
        this.applyFilters();
      });
    }

    this.statusChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        const value = chip.dataset.status;
        this.state.status = (value === 'all' || this.state.status === value) ? 'all' : value;
        this.setActiveChip(this.statusChips, this.state.status, 'status');
        this.applyFilters();
      });
    });

    this.regionChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        const value = chip.dataset.region;
        this.state.region = (value === 'all' || this.state.region === value) ? 'all' : value;
        this.setActiveChip(this.regionChips, this.state.region, 'region');
        this.applyFilters();
      });
    });

    this.root.querySelectorAll('[data-row-toggle]').forEach((head) => {
      head.addEventListener('click', () => {
        const row = head.closest('.crypto-regs__row');
        if (row) row.classList.toggle('is-open');
      });
    });

    this.resetButtons.forEach((btn) => {
      btn.addEventListener('click', () => this.reset());
    });
  }

  setActiveChip(chips, activeValue, datasetKey) {
    chips.forEach((chip) => {
      chip.classList.toggle('is-active', chip.dataset[datasetKey] === activeValue);
    });
  }

  reset() {
    this.state = { query: '', status: 'all', region: 'all' };
    if (this.searchInput) this.searchInput.value = '';
    this.setActiveChip(this.statusChips, 'all', 'status');
    this.setActiveChip(this.regionChips, 'all', 'region');
    this.applyFilters();
  }

  applyFilters() {
    let visibleTotal = 0;

    this.groups.forEach((group) => {
      let groupVisible = 0;
      const rows = group.querySelectorAll('.crypto-regs__row');

      rows.forEach((row) => {
        const { name, region, status } = row.dataset;
        let visible = true;

        if (this.state.query && !name.includes(this.state.query)) visible = false;
        if (this.state.status !== 'all' && status !== this.state.status) visible = false;
        if (this.state.region !== 'all' && region !== this.state.region) visible = false;

        row.hidden = !visible;

        if (visible) {
          groupVisible++;
          visibleTotal++;
        }
      });

      group.hidden = groupVisible === 0;

      const countEl = group.querySelector('[data-group-count]');
      if (countEl) countEl.textContent = groupVisible;
    });

    if (this.resultCountEl) this.resultCountEl.textContent = visibleTotal;
    if (this.emptyEl) this.emptyEl.hidden = visibleTotal !== 0;
  }
}

export default CryptoRegulationsTracker;
