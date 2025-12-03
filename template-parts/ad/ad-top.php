<?php if ( (is_active_sidebar( 'top-ad' ) || is_active_sidebar('us-top-ad')) && !is_front_page() && !is_search()) { ?> 
  <aside class="advert advert__top">
    <div class="container">
      <?php 
        if (function_exists('geot_target') && geot_target( 'US' )) {
          dynamic_sidebar('us-top-ad');
        } else { 
          dynamic_sidebar('top-ad');
        };
      ?>
    </div>
  </aside>
<?php } ?>