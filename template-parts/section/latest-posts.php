<?php
  $exclude_ids = $args['exclude'] ?? [];

  $latest_posts_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => $exclude_ids,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ));
?>

<?php if ($latest_posts_query->have_posts()) : ?>
  <section class="latest-posts mt-5">
    <h2 class="title h4">Latest Posts</h2>
    <div class="row mt-3">
      <?php while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post(); ?>
        <div class="col-12 col-md-6 col-lg-4 mt-3">
          <?php get_template_part('template-parts/card/card', 'chengdu'); ?>
        </div>
      <?php endwhile; ?>
    </div>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
