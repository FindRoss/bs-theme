<?php get_header(); ?>

<?php
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $query = new WP_Query(array(
    'post_type'      => 'review',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'rank',
    'order'          => 'ASC',
    'meta_query' => array(
      array(
        'key'     => 'details_group_closed',
        'value'   => '1',
        'compare' => 'NOT LIKE'
      ),
    )
  ));

  $review_types = get_terms(array(
    'taxonomy'   => 'review_type',
    'hide_empty' => true,
  ));
?>

<div class="container">
  <header class="taxonomy-header">
    <h1>Reviews</h1>
    <div class="taxonomy-header__description main--content">
      <p>Discover casino and gambling site reviews including information about bonuses, payments, and games.</p>
    </div>
  </header>
</div>

<div class="container">

  <div class="review-archive-controls">
    <div class="review-archive-search">
      <input type="search" id="review-search" placeholder="Search reviews…" autocomplete="off">
    </div>
    <?php if (!empty($review_types) && !is_wp_error($review_types)) : ?>
    <div class="review-archive-filters">
      <button class="review-filter-btn active" data-slug="">All</button>
      <?php foreach ($review_types as $type) : ?>
        <button class="review-filter-btn" data-slug="<?php echo esc_attr($type->slug); ?>">
          <?php echo esc_html($type->name); ?>
        </button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <div id="review-archive-list" class="mt-4 flex flex-col gap-3">
    <?php if ($query->have_posts()) :
      $counter = 1;
      while ($query->have_posts()) : $query->the_post(); ?>
        <?php get_template_part('template-parts/card/card', 'kunming', array('exclude_lazyload' => $counter <= 2)); ?>
        <?php $counter++; ?>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>

  <div id="review-pagination">
    <?php get_template_part('template-parts/content/content-pagination', null, ['query' => $query]); ?>
  </div>

</div>

<?php get_footer(); ?>
