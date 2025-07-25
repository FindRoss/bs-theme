<?php 
  $recommended_article = get_field('recommended_article');
  $recommended_query = new WP_Query(array('post__in' => $recommended_article));
?>


<?php if($recommended_query->have_posts() ) { ?>
  <aside class="recommended-block">
    <h4 class="recommended-block__title">
      <span class="icon"><?php echo get_svg_icon('arrow-right'); ?></span>
      <span class="title">Read More</span>
    </h4>
    <ul class="recommended-block__list">
    <?php while ( $recommended_query->have_posts() ) : $recommended_query->the_post(); ?>
      <li class="recommended-block__list-item">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </li>
    <?php endwhile; ?>
    </ul>
  </aside>
<?php }; ?>
<?php wp_reset_postdata(); ?>

