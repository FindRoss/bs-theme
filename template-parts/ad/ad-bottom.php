<?php if ((is_active_sidebar( 'bottom-ad' ) || is_active_sidebar('us-bottom-ad')) && !is_front_page() && !is_search()) { ?>
  <aside class="advert">
    <div class="container">
      <?php 
        if (function_exists('geot_target') && geot_target( 'US' )) {
          dynamic_sidebar('us-bottom-ad');
        } else { 
          dynamic_sidebar('bottom-ad');
        };
      ?>
    </div>
  </aside>
<?php } ?>