<?php get_header(); ?>

<section class="search-hero">
  <div class="container">
    <div class="search-hero__bar">
      <h1 class="search-hero__heading">Results for</h1>
      <form class="search-hero__form" id="searchForm" role="search">
        <div class="search-hero__input-wrap">
          <?php echo get_svg_icon('search'); ?>
          <input id="searchInput" type="search" name="s" placeholder="Search…" aria-label="Search" autocomplete="off">
        </div>
      </form>
      <div class="search-hero__count" id="searchResultCount"></div>
    </div>
  </div>
</section>

<div class="search-body">
  <div class="container">

    <div class="search-layout">

      <aside class="search-filter" id="searchFilter" aria-label="Search filters">
        <div class="search-filter__inner">
          <?php get_template_part('template-parts/search/filter-sidebar'); ?>
        </div>
        <div class="search-filter__drawer-header">
          <span class="search-filter__drawer-title">Filter</span>
          <button class="button button__icon filter-close-btn" id="filterCloseBtn" type="button" aria-label="Close filters">
            <?php echo get_svg_icon('close'); ?>
          </button>
        </div>
        <div class="search-filter__drawer-footer">
          <button class="button button__primary w-100" id="filterApplyBtn" type="button">Apply</button>
          <button class="button button__outline w-100 mt-2" id="filterResetBtn" type="button">Reset</button>
        </div>
      </aside>

      <div class="search-results-col">

        <div class="search-toolbar">
          <div class="search-toolbar__left">
            <button class="filter-open-btn d-lg-none" id="filterOpenBtn" type="button">
              <?php echo get_svg_icon('filter'); ?>
              Filter
              <span class="filter-badge d-none" id="filterBadge"></span>
            </button>
            <div class="active-filters d-none d-lg-flex" id="activeFilters"></div>
          </div>
          <div class="search-toolbar__right sort-control" id="sortControl">
            <span class="sort-label d-none d-lg-inline">Sort</span>
            <button class="sort-chip" id="sortChip" type="button" aria-haspopup="listbox">
              Relevance <i data-feather="chevron-down"></i>
            </button>
            <div class="sort-dropdown d-none" id="sortDropdown" role="listbox">
              <button type="button" data-sort="relevance" role="option">Relevance</button>
              <button type="button" data-sort="newest" role="option">Newest</button>
              <button type="button" data-sort="oldest" role="option">Oldest</button>
            </div>
          </div>
        </div>

        <div class="active-chips-strip d-lg-none" id="activeChipsStrip"></div>

        <div class="search-spinner d-none" id="spinner">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 100 100" class="loading-spinner">
            <circle cx="50" cy="50" r="32" stroke-width="8" stroke="var(--color-primary-500)"
              stroke-dasharray="50 150" fill="none" stroke-linecap="round"></circle>
          </svg>
        </div>

        <div id="searchResultsContainer"></div>
        <div id="searchPaginationContainer" class="py-4"></div>

      </div>
    </div>

  </div>
</div>

<div class="filter-backdrop d-none" id="filterBackdrop"></div>

<?php get_footer(); ?>
