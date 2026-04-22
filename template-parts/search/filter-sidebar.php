<div class="filter-sidebar">

  <h2 class="filter-sidebar__title">Filter</h2>

  <div class="filter-group">
    <div class="filter-group__label">TYPE</div>
    <div class="filter-group__rows" id="typeFilterRows">
      <button class="filter-row" data-filter-type="type" data-value="post" type="button">
        <span class="filter-row__dot">◯</span>
        <span class="filter-row__name">Articles</span>
        <span class="filter-row__count">—</span>
      </button>
      <button class="filter-row" data-filter-type="type" data-value="review" type="button">
        <span class="filter-row__dot">◯</span>
        <span class="filter-row__name">Reviews</span>
        <span class="filter-row__count">—</span>
      </button>
      <button class="filter-row" data-filter-type="type" data-value="bonus" type="button">
        <span class="filter-row__dot">◯</span>
        <span class="filter-row__name">Bonuses</span>
        <span class="filter-row__count">—</span>
      </button>
      <button class="filter-row" data-filter-type="type" data-value="streamer" type="button">
        <span class="filter-row__dot">◯</span>
        <span class="filter-row__name">Streamers</span>
        <span class="filter-row__count">—</span>
      </button>
    </div>
  </div>

  <div class="filter-group">
    <div class="filter-group__label">DATE</div>
    <div class="filter-group__rows">
      <button class="filter-row is-active" data-filter-type="date" data-value="anytime" type="button">
        <span class="filter-row__dot">◉</span>
        <span class="filter-row__name">Anytime</span>
      </button>
      <button class="filter-row" data-filter-type="date" data-value="last_month" type="button">
        <span class="filter-row__dot">◯</span>
        <span class="filter-row__name">Last month</span>
      </button>
      <button class="filter-row" data-filter-type="date" data-value="last_year" type="button">
        <span class="filter-row__dot">◯</span>
        <span class="filter-row__name">Last year</span>
      </button>
    </div>
  </div>

  <button class="filter-clear" id="clearAllFilters" type="button">Clear all</button>

</div>
