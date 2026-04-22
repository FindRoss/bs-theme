<?php
function search_two_endpoint() {
  register_rest_route('chaser/v2', 'search', array(
    'methods'  => 'GET',
    'callback' => 'search_two_callback',
  ));
}
add_action('rest_api_init', 'search_two_endpoint');

function search_two_callback($data) {
  $search_term = sanitize_text_field($data['term'] ?? '');
  $order       = sanitize_text_field($data['order']   ?? 'DESC');
  $orderby     = sanitize_text_field($data['orderby'] ?? 'relevance');
  $date_filter = sanitize_text_field($data['date']    ?? 'anytime');

  $all_filterable_types = ['post', 'review', 'bonus', 'streamer'];

  // Accept types as JSON array or 'all' (legacy: single 'type' param)
  $types_raw = $data['types'] ?? $data['type'] ?? 'all';
  if ($types_raw === 'all' || empty($types_raw)) {
    $post_types = array_merge($all_filterable_types, ['page', 'slot', 'glossary']);
  } else {
    $decoded = json_decode($types_raw, true);
    $post_types = is_array($decoded) ? array_values(array_intersect($decoded, $all_filterable_types)) : $all_filterable_types;
    if (empty($post_types)) $post_types = $all_filterable_types;
  }

  // Topics: JSON array of term slugs
  $topics_raw = $data['topics'] ?? '';
  $topics = (!empty($topics_raw) && $topics_raw !== '[]') ? json_decode($topics_raw, true) : [];
  if (!is_array($topics)) $topics = [];
  $topics = array_map('sanitize_text_field', $topics);

  $page = !empty($data['page']) ? absint($data['page']) : 1;

  // Base query args
  $args = [
    's'              => $search_term,
    'post_type'      => $post_types,
    'posts_per_page' => 20,
    'paged'          => $page,
    'order'          => $order,
    'orderby'        => $orderby,
  ];

  // Date filter
  if ($date_filter === 'last_month') {
    $args['date_query'] = [['after' => date('Y-m-d', strtotime('-1 month')), 'inclusive' => true]];
  } elseif ($date_filter === 'last_year') {
    $args['date_query'] = [['after' => date('Y-m-d', strtotime('-1 year')), 'inclusive' => true]];
  }

  // Topics tax_query
  if (!empty($topics)) {
    $tax_query = ['relation' => 'OR'];
    foreach (['cryptocurrency', 'game', 'provider', 'payment', 'bonus_type'] as $tax) {
      $tax_query[] = ['taxonomy' => $tax, 'field' => 'slug', 'terms' => $topics, 'operator' => 'IN'];
    }
    $args['tax_query'] = $tax_query;
  }

  $query = new WP_Query($args);

  // Per-type counts (always against all filterable types, not filtered by types param)
  $label_map = ['post' => 'Article', 'review' => 'Review', 'bonus' => 'Bonus', 'streamer' => 'Streamer'];
  $counts = [];
  foreach ($all_filterable_types as $type) {
    $count_args = [
      's'              => $search_term,
      'post_type'      => $type,
      'posts_per_page' => 1,
      'fields'         => 'ids',
      'no_found_rows'  => false,
    ];
    if (isset($args['date_query'])) $count_args['date_query'] = $args['date_query'];
    if (isset($args['tax_query']))  $count_args['tax_query']  = $args['tax_query'];
    $count_q = new WP_Query($count_args);
    $counts[$type] = (int) $count_q->found_posts;
    wp_reset_postdata();
  }

  // Taxonomy terms matching search
  $terms = [];
  $get_terms = get_terms([
    'taxonomy' => ['cryptocurrency', 'game', 'provider', 'payment', 'bonus_type'],
    'search'   => $search_term,
    'number'   => 8,
    'orderby'  => 'name',
    'order'    => 'ASC',
  ]);
  if (!is_wp_error($get_terms)) {
    foreach ($get_terms as $term) {
      $image_from_term = get_field('icon', $term);
      $terms[] = [
        'title' => $term->name,
        'slug'  => $term->slug,
        'link'  => get_term_link($term->term_id, $term->taxonomy),
        'image' => isset($image_from_term['sizes']['thumbnail']) ? $image_from_term['sizes']['thumbnail'] : null,
      ];
    }
  }

  // Results
  $results = [];
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $post_type = get_post_type();
      $excerpt   = get_the_excerpt();
      if (!$excerpt) {
        $excerpt = wp_trim_words(strip_tags(get_the_content()), 30, '…');
      }
      $bonus_link = '';
      if ($post_type === 'bonus') {
        $cta = get_field('cta_link');
        $bonus_link = $cta ?: get_the_permalink();
      }
      $results[] = [
        'title'     => get_the_title(),
        'link'      => get_the_permalink(),
        'postType'  => $post_type,
        'label'     => $label_map[$post_type] ?? ucfirst($post_type),
        'image'     => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: null,
        'excerpt'   => $excerpt,
        'bonusLink' => $bonus_link,
      ];
    }
    wp_reset_postdata();
  }

  return [
    'terms'       => $terms,
    'results'     => $results,
    'counts'      => $counts,
    'currentPage' => $page,
    'totalPages'  => $query->max_num_pages,
    'totalPosts'  => $query->found_posts,
  ];
}
