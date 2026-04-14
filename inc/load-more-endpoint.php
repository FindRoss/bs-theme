<?php

function km_load_more_endpoint() {
  register_rest_route('chaser/v2', 'reviews', array(
    'methods'             => 'GET',
    'callback'            => 'km_load_more_callback',
    'permission_callback' => '__return_true',
  ));
}

add_action('rest_api_init', 'km_load_more_endpoint');

function km_load_more_callback($data) {
  $taxonomy  = sanitize_key($data['taxonomy']);
  $term_slug = sanitize_text_field($data['term']);
  $page      = !empty($data['page']) ? absint($data['page']) : 1;
  $per_page  = !empty($data['per_page']) ? absint($data['per_page']) : 6;

  if (!$taxonomy || !$term_slug) {
    return new WP_Error('missing_params', 'taxonomy and term are required', array('status' => 400));
  }

  $args = array(
    'post_type'      => 'review',
    'posts_per_page' => $per_page,
    'paged'          => $page,
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
    'meta_key'       => 'rank',
    'tax_query'      => array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $term_slug,
      ),
    ),
    'meta_query' => array(
      'relation' => 'OR',
      array(
        'key'     => 'closed',
        'value'   => '1',
        'compare' => '!=',
      ),
      array(
        'key'     => 'closed',
        'compare' => 'NOT EXISTS',
      ),
    ),
  );

  $query = new WP_Query($args);

  ob_start();

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      get_template_part('template-parts/card/card', 'kunming');
    }
    wp_reset_postdata();
  }

  $html = ob_get_clean();

  return array(
    'html'        => $html,
    'currentPage' => $page,
    'totalPages'  => (int) $query->max_num_pages,
  );
}
