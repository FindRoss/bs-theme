<?php
$exclude_ids = $args['exclude'] ?? [];

$latest_posts_query = new WP_Query(array(
  'post_type'      => 'post',
  'posts_per_page' => 4,
  'post__not_in'   => $exclude_ids,
  'orderby'        => 'date',
  'order'          => 'DESC',
));
?>

<?php if ($latest_posts_query->have_posts()) : ?>
<section class="review-latest-posts">
  <h2 class="review-latest-posts__heading">Latest Posts</h2>
  <div class="review-latest-posts__grid">
    <?php while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post(); ?>
      <a class="review-post-card" href="<?php the_permalink(); ?>">
        <h3 class="review-post-card__title"><?php the_title(); ?></h3>
        <?php if (has_excerpt()) : ?>
          <p class="review-post-card__lede"><?php echo get_the_excerpt(); ?></p>
        <?php endif; ?>
      </a>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>
<?php endif; ?>
