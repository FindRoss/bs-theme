<?php
  $exclude_ids = $args['exclude'] ?? [];

  $latest_posts_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'post__not_in'   => $exclude_ids,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => bonus_expired_meta_query()
  ));
?>

<?php if ($latest_posts_query->have_posts()) : ?>
  <section class="mt-5 articles-box">
    <h2 class="title h4">Latest Posts</h2>
    <?php while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post(); ?>
      <?php get_template_part('template-parts/card/card', 'chengdu'); ?>
    <?php endwhile; ?>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
