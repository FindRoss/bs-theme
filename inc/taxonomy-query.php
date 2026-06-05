<?php

// I love this site: https://www.justetf.com/en/how-to/sp-500-etfs.html

function build_taxonomy_main_query( WP_Term $term, int $paged = 1 ): WP_Query {
  $selected   = get_field( 'featured_reviews', $term );
  $pinned_ids = ! empty( $selected )
    ? array_map( fn( $p ) => is_object( $p ) ? $p->ID : (int) $p, $selected )
    : [];

  $closed_meta = array(
    'relation' => 'OR',
    array( 'key' => 'details_group_closed', 'compare' => 'NOT EXISTS' ),
    array( 'key' => 'details_group_closed', 'value' => '1', 'compare' => '!=' ),
  );

  if ( ! empty( $pinned_ids ) ) {
    return new WP_Query( array(
      'post_type'      => 'review',
      'posts_per_page' => count( $pinned_ids ),
      'post__in'       => $pinned_ids,
      'orderby'        => 'post__in',
      'meta_query'     => $closed_meta,
    ) );
  }

  return new WP_Query( array(
    'post_type'      => 'review',
    'posts_per_page' => 5,
    'paged'          => $paged,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'rank',
    'order'          => 'ASC',
    'tax_query'      => array(
      array(
        'taxonomy' => $term->taxonomy,
        'field'    => 'term_id',
        'terms'    => $term->term_id,
      ),
    ),
    'meta_query'     => $closed_meta,
  ) );
}

function taxonomy_main_query($query, $term): void {

  if (!$query->have_posts()) return;
  ?>

<div class="container">
  <div
    id="km-card-list"
    class="mt-4 flex flex-col gap-3"
    data-term="<?php echo $term ? esc_attr($term->slug) : ''; ?>"
    data-taxonomy="<?php echo $term ? esc_attr($term->taxonomy) : ''; ?>"
    data-total-pages="<?php echo esc_attr($query->max_num_pages); ?>"
  >
    <?php if ( $query->have_posts() ) :
      $counter = 1;
      while ( $query->have_posts() ) : $query->the_post() ?>
        <?php get_template_part('template-parts/card/card', 'kunming', array('exclude_lazyload' => $counter <= 2, 'is_top' => $counter === 1)); ?>
        <?php $counter++; ?>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>

  <?php if ($query->max_num_pages > 1) : ?>
    <div class="km-load-more-wrapper mt-3">
      <button class="km-load-more button button__outline" data-page="2">
        <i data-feather="chevron-down"></i>
        <span>Load More</span>
      </button>
    </div>
  <?php endif; ?>
</div><!-- .container -->


<?php }; ?>
