<?php
  $top_ad_id = (function_exists('geot_target') && geot_target('US')) ? 'us-top-ad' : 'top-ad';
?>
<?php if ( is_active_sidebar( $top_ad_id ) && !is_front_page() && !is_search()) { ?>
  <aside class="advert advert__top">
    <div class="container">
      <?php dynamic_sidebar($top_ad_id); ?>
    </div>
  </aside>
<?php } ?>