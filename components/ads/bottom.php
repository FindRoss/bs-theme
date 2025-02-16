<?php if ((is_active_sidebar( 'bottom-ad' ) || is_active_sidebar('us-bottom-ad')) && !is_front_page() && !is_search()) { ?>
  <aside class="mb-4 pt-4">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center ad-bottom">
            <?php 
              if (function_exists('geot_target') && geot_target( 'US' )) {
                dynamic_sidebar('us-bottom-ad');
              } else { 
                dynamic_sidebar('bottom-ad');
              };
            ?>
          </div>
        </div>
      </div>
    </div>
  </aside>
<?php } ?>