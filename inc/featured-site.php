<?php

// Feature Casino Section
function featured_site_section() {

  $site_of_the_month = get_field('site_of_the_month', 'options'); 

  if ($site_of_the_month) { 
    $site     = $site_of_the_month['site'];

  if ($site) {
    $details_group = get_field('details_group', $site);
    $site_name     = $details_group['name']; 
    $aff_link      = $details_group['affiliate_link']; 

    $media_group    = get_field('media_group', $site);
    $homepage_image = $media_group['homepage'];
  ?>

  <div class="my-5 bg-light">
    <div class="container">
        <div class="row flex-column flex-column-reverse flex-lg-row justify-content-between">
          <div class="col-12 col-lg-6 d-block d-lg-flex flex-column justify-content-between py-4">
            <div>
              <div class="ff-main">FEATURED SITE</div>
              <h2 class="mt-1"><?php echo $site_name; ?></h2>
              <p style="font-size: 18px; max-width: 45ch;"><?php echo get_the_excerpt($site); ?></p>
            </div>
            <div class="d-flex gap-2">
              <a href="<?php echo get_the_permalink($site); ?>"class="button button__outline">Read Review</a>
              <a href="<?php echo $aff_link; ?>" rel="nofollow" class="button button__primary" target="_blank">Play Now</a>
            </div>
          </div>
          <div class="col-12 col-lg-6 d-lg-flex flex-column justify-content-center pt-4 pb-0 py-lg-4 ">
            <?php if ($homepage_image) { ?>
              <img class="w-100 h-auto rounded" width="476" height="279" src="<?php echo $homepage_image; ?>" alt="Screenshot of <?php echo $site_name; ?>"> 
            <?php }; ?>
          </div>
        </div><!-- .row --> 
    </div>
  </div> 

  <?php };
  };
};