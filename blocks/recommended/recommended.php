<?php 
  $recommended_article = get_field('recommended_article');
  $recommended_query = new WP_Query(array('post__in' => $recommended_article));
?>


<?php if($recommended_query->have_posts() ) { ?>
  <aside class="recommended-block">
    <h4 class="recommended-block__title">
      <span class="icon"><i data-feather="arrow-right-circle"></i></span>
      <span class="title">Read More</span>
    </h4>
    <ul class="recommended-block__list">
    <?php while ( $recommended_query->have_posts() ) : $recommended_query->the_post(); ?>
      <li class="recommended-block__list-item">
        <a class="img-link" href="<?php the_permalink(); ?>">
          <div class="item">
            <img width="40" height="40" src="<?php echo esc_url( get_the_post_thumbnail_url( null, 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
            <?php the_title(); ?>
          </div>
        </a>
      </li>
    <?php endwhile; ?>
    </ul>
  </aside>
<?php }; ?>
<?php wp_reset_postdata(); ?>

