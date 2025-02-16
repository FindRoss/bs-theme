<div class="streamer-card">  

  <div class="streamer-card__media">
    <img src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" alt="<?php the_title() ?>" width="500" height="333">
  </div>

  <h3>
    <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h3>

</div><!-- .streamer-card --> 