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
      
      <div class="sec-head">
        <?php if ($heading) { ?>
        <div class="sec-head__l">
          <span class="sec-head__bar"></span>
          <div class="sec-head__titles">
            <h2 class="sec-head__title"><?php echo esc_html($heading); ?></h2>
          </div>
        </div>
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
        <div class="sec-head">
          <div class="sec-head__l">
            <span class="sec-head__bar"></span>
            <div class="sec-head__titles">
              <h2 class="sec-head__title"><?php echo esc_html($heading); ?></h2>
            </div>
          </div>
          <?php if ($link) { ?>
            <a class="sec-head__link" href="<?php echo esc_url($link); ?>">
              <span>View all</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
            </a>
          <?php } ?>
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