<?php

function outputBigSlideHTML($query = NULL) {
  
  if ($query->have_posts()): 
    
    $postType = $query->query_vars['post_type'];
  ?>
 
    <div class="swiper swiper-big">
      <div class="swiper-controls">
        <button class="button button__icon swiper-button-prev" aria-label="Previous slide">
          <?php echo get_svg_icon('chevron-left') ?>
        </button>
        <button class="button button__icon swiper-button-next" aria-label="Next slide">
          <?php echo get_svg_icon('chevron-right') ?>
        </button>
      </div>
      <div class="swiper-wrapper">
        <?php while ($query->have_posts()) : $query->the_post(); 
        
        if ($postType == 'review') {

          $details_group = get_field('details_group');
          $name          = $details_group['name']; 
          $link          = $details_group['affiliate_link']; 
          $bonus         = $details_group['bonus']; 
          
          $mediaGroup = get_field('media_group');
          $siteColor = $mediaGroup['theme_color'];
          $homepageImage = $mediaGroup['homepage'];

          $excerpt = get_the_excerpt();          
        }
        ?>
          <div class="swiper-slide <?php getTextColorForBackground($siteColor); ?>"  style="background-color: <?php echo $siteColor; ?>">
            <?php
            
              if ($postType == 'review') { ?>
                <div class="row h-100 w-100 justify-content-between">
                  <div class="col-12 col-lg-4 swiper-slide__content-left">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'site-small-logo'); ?>" width="200" height="100" aria-hidden="true" alt="<?php echo $name . ' logo'; ?>">
                    
                    <?php if ($excerpt) { ?>
                      <div>
                        <p><?php echo $excerpt; ?></p>
                      </div>
                    <?php }; ?>

                    <div class="swiper-slide__button-group">
                      <a class="button button__outline" href="<?php echo get_the_permalink(); ?>">Review</a>
                      <a class="button button__primary" href="<?php echo $link; ?>" target="_blank">Visit</a>
                    </div>
                  </div>
                  <div class="col-12 col-lg-5 swiper-slide__content-right">
                    <img class="w-100 h-auto swiper-slide__homepage-image" src="<?php echo $homepageImage; ?>" alt="Screenshot of <?php echo $name; ?>"/>
                  </div>
                </div>
                
               
              <?php } 
              
            ?>
          </div>
        <?php endwhile; ?>
      </div>
    
      <div class="swiper-pagination"></div>
      <!-- <div class="swiper-button-prev"></div> -->
      <!-- <div class="swiper-button-next"></div> -->
    </div>

    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
<?php };


function getTextColorForBackground($backgroundHex) {

    if (!$backgroundHex) echo 'swiper-big__light'; 

    // Remove the hash if present
    $backgroundHex = ltrim($backgroundHex, '#');

    // Convert hex to RGB
    $r = hexdec(substr($backgroundHex, 0, 2));
    $g = hexdec(substr($backgroundHex, 2, 2));
    $b = hexdec(substr($backgroundHex, 4, 2));

    // Calculate luminance (using the relative luminance formula)
    $luminance = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;

    // Decide if the text should be light or dark based on luminance
    echo ($luminance > 128) ? 'swiper-slide__light' : 'swiper-slide__dark';
};