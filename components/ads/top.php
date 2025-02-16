<!--  if ( (is_active_sidebar( 'top-ad' ) || is_active_sidebar('us-top-ad')) && !is_front_page() && !is_search()) { ?>
<aside class="mb-4">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="d-flex justify-content-center ad-top">
          if (function_exists('geot_target') && geot_target( 'US' )) {
            dynamic_sidebar( 'us-top-ad' );
          } else { 
            dynamic_sidebar( 'top-ad' );
          } ?>
        </div>
      </div>
    </div>
  </div>
</aside>
} ?> -->