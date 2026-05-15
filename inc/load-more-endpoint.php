<?php

function km_load_more_endpoint() {
  register_rest_route('chaser/v2', 'reviews', array(
    'methods'             => 'GET',
    'callback'            => 'km_load_more_callback',
    'permission_callback' => '__return_true',
  ));
}

add_action('rest_api_init', 'km_load_more_endpoint');

function km_load_more_bonuses_endpoint() {
  register_rest_route('chaser/v2', 'bonuses', array(
    'methods'             => 'GET',
    'callback'            => 'km_load_more_bonuses_callback',
    'permission_callback' => '__return_true',
  ));
}
add_action('rest_api_init', 'km_load_more_bonuses_endpoint');

function km_load_more_bonuses_callback($data) {
  $taxonomy  = sanitize_key($data['taxonomy']);
  $term_slug = sanitize_text_field($data['term']);
  $page      = !empty($data['page']) ? absint($data['page']) : 1;
  $per_page  = !empty($data['per_page']) ? absint($data['per_page']) : 6;

  if (!$taxonomy || !$term_slug) {
    return new WP_Error('missing_params', 'taxonomy and term are required', array('status' => 400));
  }

  $term     = get_term_by('slug', $term_slug, $taxonomy);
  $featured = get_field('featured_bonuses', $term) ?? [];
  $featured = array_map('intval', $featured);

  $additional = get_posts(array(
    'post_type'      => 'bonus',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'tax_query'      => array(array(
      'taxonomy' => $taxonomy,
      'field'    => 'slug',
      'terms'    => $term_slug,
    )),
    'meta_query'   => bonus_expired_meta_query(),
    'post__not_in' => $featured,
  ));

  $merged = array_merge($featured, $additional);

  if (empty($merged)) {
    return array('html' => '', 'currentPage' => 1, 'totalPages' => 0);
  }

  $query = new WP_Query(array(
    'post_type'      => 'bonus',
    'posts_per_page' => $per_page,
    'paged'          => $page,
    'post__in'       => $merged,
    'orderby'        => 'post__in',
    'meta_query'     => bonus_expired_meta_query(),
  ));

  ob_start();
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      get_template_part('template-parts/card/card', 'suzhou');
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

function km_load_more_callback($data) {
  $taxonomy  = sanitize_key($data['taxonomy']);
  $term_slug = sanitize_text_field($data['term']);
  $page      = !empty($data['page']) ? absint($data['page']) : 1;
  $per_page  = !empty($data['per_page']) ? absint($data['per_page']) : 5;

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

function km_review_search_endpoint() {
  register_rest_route('chaser/v2', 'reviews/search', array(
    'methods'             => 'GET',
    'callback'            => 'km_review_search_callback',
    'permission_callback' => '__return_true',
  ));
}
add_action('rest_api_init', 'km_review_search_endpoint');

function km_review_search_callback($data) {
  $q           = sanitize_text_field($data['q'] ?? '');
  $review_type = sanitize_key($data['review_type'] ?? '');
  $page        = !empty($data['page'])     ? absint($data['page'])     : 1;
  $per_page    = !empty($data['per_page']) ? absint($data['per_page']) : 12;

  $args = array(
    'post_type'      => 'review',
    'posts_per_page' => $per_page,
    'paged'          => $page,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'rank',
    'order'          => 'ASC',
    'meta_query'     => array(
      array(
        'key'     => 'details_group_closed',
        'value'   => '1',
        'compare' => 'NOT LIKE'
      ),
    ),
  );

  if (!empty($q)) {
    $args['s'] = $q;
  }

  if (!empty($review_type)) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'review_type',
        'field'    => 'slug',
        'terms'    => $review_type,
      ),
    );
  }

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

  $total_pages    = (int) $query->max_num_pages;
  $pagination_html = '';

  if ($total_pages > 1) {
    $links = paginate_links(array(
      'base'      => '?paged=%#%',
      'format'    => '',
      'current'   => $page,
      'total'     => $total_pages,
      'prev_text' => '&lt;',
      'next_text' => '&gt;',
    ));

    if ($links) {
      $pagination_html = '<div class="custom-pagination py-3">' . $links . '</div>';
    }
  }

  return array(
    'html'           => $html,
    'count'          => $query->found_posts,
    'currentPage'    => $page,
    'totalPages'     => $total_pages,
    'paginationHtml' => $pagination_html,
  );
}
