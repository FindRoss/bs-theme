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
      <!-- Filter --> 
      <?php render_filter_items(); ?>
    </div><!-- .filter-overlay__content --> 

    <div class="filter-overlay__footer">
      <div class="d-flex flex-column align-items-center">
        <button class="button button__primary" id="filterApplyBtn" aria-label="Apply selected filters">Apply</button>
        <div class="filter-reset mt-1" id="filterResetBtn">Reset</div>
      </div>
    </div>
  </div><!-- .filter-overlay --> 


  <?php 
  $filter_output = ob_get_clean();
  echo $filter_output;
} ?>