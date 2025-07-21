<?php get_header(); ?>

<?php 

// Type
$filterTitle = 'Type';
$filterItems = array(
  'post' => 'Posts',
  'review' => 'Reviews',
  'bonus' => 'Bonuses', 
  'streamer' => 'Streamers'
);

render_filter_overlay($filterTitle, $filterItems); ?>


<section class="search-form-section" style="margin-top: -1.5rem;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <h1>Search results for</h1>
        <form class="search-form w-100" id="searchForm" role="search">
          <div class="search-form__layout">
            <div class="search">
              <!-- .form-control -->
              <input class="" id="searchInput" type="search" placeholder="" aria-label="Search" value="" name="search" type="text">
              <button class="button button__outline button__icon" id="searchButton" type="submit"><?php echo get_svg_icon('search'); ?></button>
            </div>
            <!-- <div class="filter d-block d-sm-none">
              <button class="button button__outline" id="searchButtonFilter" type="button">
                <span class="filter-icon"><?php echo get_svg_icon('filter'); ?></span> Filter
                <span class="filter-count d-none">1</span>
              </button>
            </div> -->
          </div>
        </form>
      </div><!-- .col -->
    </div><!-- .row --> 
  </div><!-- .container -->
</section>



<section class="search-results-section" style="min-height: 250px;">
  <div class="container">
    <div class="search-results-layout">
      <div class="search-results-layout__filter">
        
        <div class="desktop-filter">
          <div class="py-2 d-flex align-items-center" style="height: 60px">
            <div><span class="filter-icon"><?php echo get_svg_icon('filter'); ?></span> <span style="font-weight: 500; font-size: 18px;">Filter</span></div>
          </div>
          
          <div>
            <?php render_filter_items($filterTitle, $filterItems); ?>
          </div>

          <button class="button button__primary w-100 mt-3" id="filterApplyBtn">Apply</button>
          <div class="button button__outline w-100 mt-1" id="filterResetBtn">Reset</div>
          <!-- <div class="filter-reset text-center mt-2" id="filterResetBtn">Reset</div> -->
        </div><!-- .desktop-filter --> 

      </div>
      <div class="search-results-layout__results">

        <div class="py-2 d-flex justify-content-between align-items-center" style="height: 60px">
          <div class="search-results-count" id="search-results-count-container"></div>
          
          <div class="d-flex align-items-center search-sort-by">
            <span class="title">Sort By</span>
            <select class="form-select" id="searchSelect" aria-label="Order results">
              <option value="relevance" selected>Relevance</option>
              <option value="date_desc">Newest</option>
              <option value="date_asc">Oldest</option>
            </select>
          </div>
        </div>

        <div class="spinner" id="spinner">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 100 100" class="loading-spinner">
            <circle
              cx="50"
              cy="50"
              r="32"
              stroke-width="8"
              stroke="#3498db"
              stroke-dasharray="50 150"
              fill="none"
              stroke-linecap="round">
            </circle>
          </svg>
        </div>
        
        <!-- Search Results -->
        <div id="search-results-container"></div>
        <!-- Pagination -->
        <div class="py-4" id="search-pagination-container"></div>

      </div><!-- .col --> 
    </div><!-- .row --> 
  </div><!-- .container --> 
</section>




 
<?php get_footer();?>
 




