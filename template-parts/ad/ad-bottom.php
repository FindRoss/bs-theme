<?php
  $bottom_ad_id = (function_exists('geot_target') && geot_target('US')) ? 'us-bottom-ad' : 'bottom-ad';
?>
<?php if (is_active_sidebar( $bottom_ad_id ) && !is_front_page() && !is_search()) { ?>
  <aside class="advert advert__bottom">
    <div class="container">
      <?php dynamic_sidebar($bottom_ad_id); ?>
    </div>
  </aside>
<?php } ?>