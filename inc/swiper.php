<?php 

function outputNewSlideHTML($args) {
  $query = $args['query'] ?? NULL;
  $heading = esc_html($args['heading'] ?? '');
  $link = esc_url($args['link'] ?? '');
  
  if ($query->have_posts()): 
    $postType = $query->query_vars['post_type'];
  ?>


    <div class="swiper swiper-primary" aria-label="Carousel of <?php echo esc_attr($postType); ?> posts">
      <div class="section-heading d-flex justify-content-between align-items-center">

        <?php if ($heading) { ?>
        <h2 class="section-heading__title h4">
          <?php 
            if ($link) { echo '<a href="' . $link . '">'; } 
              echo $heading; 
            if ($link) { echo get_svg_icon('chevron-right') . '</a>'; } 
          ?>
        </h2>
        <?php }; ?>

        <div class="swiper-controls">
          <button class="button button__icon swiper-button-prev" aria-label="Previous slide">
            <?php echo get_svg_icon('chevron-left') ?>
          </button>
          <button class="button button__icon swiper-button-next" aria-label="Next slide">
            <?php echo get_svg_icon('chevron-right') ?>
          </button>
        </div>

      </div>

      <div class="swiper-wrapper">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
          <div class="swiper-slide" role="group" aria-roledescription="slide" aria-label="<?php the_title_attribute(); ?>">
            <?php

              if ($postType == 'post') {
                require locate_template('components/card/article.php');
              }
              
              if ($postType == 'review') {
                require locate_template('components/card/review-excerpt.php');
              } 
              
              if ($postType == 'bonus') {
                require locate_template('components/card/bonus-cover.php');
              }

              if ($postType == 'streamer') {
                require locate_template('components/card/streamer.php');
              }
              
            ?>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>

    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
<?php }; 

// Not using this anywhere in theme. 
function outputSlideHTML($query = NULL) {
  
  if ($query->have_posts()): 
    $postType = $query->query_vars['post_type'];
  ?>
 
    <div class="swiper swiper-primary" aria-label="Carousel of <?php echo esc_attr($postType); ?> posts">
      <div class="swiper-controls">
        <button class="button button__icon swiper-button-prev" aria-label="Previous slide">
          <?php echo get_svg_icon('chevron-left') ?>
        </button>
        <button class="button button__icon swiper-button-next" aria-label="Next slide">
          <?php echo get_svg_icon('chevron-right') ?>
        </button>
      </div>
      <div class="swiper-wrapper">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
          <div class="swiper-slide" role="group" aria-roledescription="slide" aria-label="<?php the_title_attribute(); ?>">
            <?php

              if ($postType == 'post') {
                require locate_template('components/card/article.php');
              }
              
              if ($postType == 'review') {
                require locate_template('components/card/review-excerpt.php');
              } 
              
              if ($postType == 'bonus') {
                require locate_template('components/card/bonus-cover.php');
              }

              if ($postType == 'streamer') {
                require locate_template('components/card/streamer.php');
              }
              
            ?>
          </div>
        <?php endwhile; ?>
      </div>
    
      <div class="swiper-pagination"></div>

    </div>

    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
<?php }; 


