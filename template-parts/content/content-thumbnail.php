 <?php if (has_post_thumbnail()) : ?>
    <picture>
      <!-- Large image for desktop -->
      <source media="(min-width: 768px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>">
      <!-- Medium image for mobile -->
      <source media="(max-width: 767px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>">
      <!-- Fallback for browsers that don't support <picture> -->
      <img class="w-100 h-auto border box-shadow-sm my-4 rounded-corners" 
          src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" 
          alt="<?php the_title_attribute(); ?>" 
          title="<?php the_title_attribute(); ?>" 
          width="800"
          height="480"
          />
    </picture>
  <?php endif; ?>