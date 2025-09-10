<?php 

function outputNewSlideHTML($args) {
  $query    = $args['query'] ?? NULL;
  $heading  = esc_html($args['heading'] ?? '');
  $link     = esc_url($args['link'] ?? '');
  $cardType = $args['card_type'] ?? '';

  if (!($query instanceof WP_Query)) {
    return;
  }

  $postCount = $query->found_posts; 
  $postType = $query->query_vars['post_type'];
  
  if ($query->have_posts() AND $postCount > 3): ?>
    <div class="swiper swiper-primary" aria-label="Carousel of <?php echo esc_attr($postType); ?> posts">
      
      <div class="section-heading">
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
              if ($cardType == 'shanghai') {
                get_template_part('template-parts/card/card', 'shanghai');
              } else if ($postType == 'post') {
                 get_template_part('template-parts/card/card', 'beijing');
              } else if ($postType == 'review') {
                get_template_part('template-parts/card/card', 'hong-kong');
              } else if ($postType == 'bonus') {
                get_template_part('template-parts/card/card', 'shanghai');
              } else if ($postType == 'streamer') {
                get_template_part('template-parts/card/card', 'streamer');
              }  
            ?>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>

  <?php elseif ($query->have_posts() AND $postCount <= 3) :  ?>
      
      <?php if ($heading) { ?>
        <div class="section-heading">
          <h2 class="section-heading__title h4">
            <?php 
              if ($link) { echo '<a href="' . $link . '">'; } 
                echo $heading; 
              if ($link) { echo get_svg_icon('chevron-right') . '</a>'; } 
            ?>
          </h2>
        </div>
      <?php }; ?>  

      <div class="swiper-plain-row">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
          <?php
            if ($cardType == 'shanghai') {
              get_template_part('template-parts/card/card', 'shanghai');
            } else if ($postType == 'post') {
                get_template_part('template-parts/card/card', 'beijing');
            } else if ($postType == 'review') {
              get_template_part('template-parts/card/card', 'hong-kong');
            } else if ($postType == 'bonus') {
              get_template_part('template-parts/card/card', 'shanghai');
            } else if ($postType == 'streamer') {
              get_template_part('template-parts/card/card', 'streamer'); 
            }  
          ?>
        <?php endwhile; ?>
      </div>

    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
<?php }; 