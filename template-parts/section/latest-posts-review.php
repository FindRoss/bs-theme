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
<section class="latest-posts-grid">
  <h2 class="group-heading">Latest Posts</h2>
  <div class="latest-posts-grid__grid">
    <?php while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post(); ?>
      <a class="card-nanjing" href="<?php the_permalink(); ?>">
        <div class="card-nanjing__body">
          <h3 class="card-nanjing__title"><?php the_title(); ?></h3>
          <?php if (has_excerpt()) : ?>
            <p class="card-nanjing__lede"><?php echo get_the_excerpt(); ?></p>
          <?php endif; ?>
        </div>
        <?php if (has_post_thumbnail()) : ?>
          <div class="card-nanjing__thumb">
            <?php the_post_thumbnail('thumbnail', array('loading' => 'lazy', 'alt' => '')); ?>
          </div>
        <?php endif; ?>
      </a>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>
<?php endif; ?>
