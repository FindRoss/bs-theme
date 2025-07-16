<?php 



function render_filter_overlay($title, $filerItems) {
  
  if ($title == '') return;
  
  ob_start(); ?>

  <div class="filter-overlay d-none" id="filterOverlay">

    <div class="filter-overlay__header">
      <div class="title">Filter <?php echo get_svg_icon('filter'); ?></div>
      <div>
        <button class="button button__outline" id="filterOverlayClose" type="button" aria-label="Close filter overlay"><?php echo get_svg_icon('close'); ?></button>
      </div>
    </div>

    <div class="filter-overlay__content">
      <?php render_filter_items(); ?>
    </div>

    <div class="filter-overlay__footer">
      <button class="button button__primary" id="filterApplyBtn" aria-label="Apply selected filters">Apply</button>
      <button class="button button__outline" id="filterResetBtn" aria-label="Reset all filters">Reset</button>
    </div>
  </div><!-- .filter-overlay --> 


  <?php 
  $filter_output = ob_get_clean();
  echo $filter_output;
} ?>