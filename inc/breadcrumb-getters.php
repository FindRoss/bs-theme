<?php

function get_post_breadcrumbs(): array {
  if (!is_singular('post')) {
      return [];
  }

  $primary_category = null;

  if (class_exists('WPSEO_Primary_Term')) {
      $primary_term = new WPSEO_Primary_Term('category', get_the_ID());
      $primary_term_id = $primary_term->get_primary_term();

      if (!is_wp_error($primary_term_id)) {
          $primary_category = get_category($primary_term_id);
      }
  }

  // Early return if no valid primary category
  if (!isset($primary_category->term_id) || $primary_category->term_id <= 1) {
      return [];
  }

  $primary_id = $primary_category->term_id;
  $post_categories = get_the_category();
  $breadcrumb_path = [$primary_category];
  $deepest_path = [];

  foreach ($post_categories as $cat) {
      if ($cat->term_id === $primary_id) continue;

      $path = [];
      $current = $cat;

      while ($current && $current->parent != 0) {
      array_unshift($path, $current);
      $current = get_category($current->parent);
      if ($current->term_id == $primary_id) {
        array_unshift($path, $current);
        if (count($path) > count($deepest_path)) {
            $deepest_path = $path;
        }
        break;
      }
    }
  }

  if (!empty($deepest_path)) {
      $breadcrumb_path = $deepest_path;
  }

  $items = [];
  foreach ($breadcrumb_path as $cat) {
      $items[] = ['name' => $cat->name, 'url' => get_category_link($cat->term_id)];
  }

  return $items;
}

function get_category_breadcrumbs(): array {
	if (!is_category()) return [];

	$term = get_queried_object();

  if ($term->parent === 0) {
    return [];
  }

  $items = [];

  $parent_category = get_category($term->parent);

  if ($parent_category->parent !== 0) {
    $grandparent_category = get_category($parent_category->parent);
    $items[] = ['name' => $grandparent_category->name, 'url' => get_category_link($grandparent_category->term_id)];
  }

  $items[] = ['name' => $parent_category->name, 'url' => get_category_link($parent_category->term_id)];
  $items[] = ['name' => $term->name, 'url' => ''];

	return $items;
}

function get_review_breadcrumbs(): array {

    if (!is_singular('review')) return [];

    $primary_id = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_review_type', true );

    $items = [
      ['name' => 'Reviews', 'url' => home_url('/reviews/')],
    ];

    if ($primary_id) {
      $term_link = get_term_link( (int) $primary_id, 'review_type' );
      if (!is_wp_error( $term_link )) {
        $items[] = ['name' => get_term( $primary_id )->name, 'url' => $term_link];
      }
    }

    $items[] = ['name' => get_the_title(get_the_ID()), 'url' => ''];

    return $items;
}

function get_taxonomy_breadcrumbs($term): array {
  if (!$term) return [];

  $taxonomy = $term->taxonomy;

  $items = [
    ['name' => 'Reviews', 'url' => home_url('/reviews/')],
  ];

  switch ( $taxonomy ) {
    case 'cryptocurrency':
      $items[] = ['name' => 'Crypto', 'url' => home_url('/crypto/')];
      break;

    case 'game':
      $items[] = ['name' => 'Games', 'url' => home_url('/online-casino-games/')];
      break;

    case 'provider':
      $items[] = ['name' => 'Providers', 'url' => home_url('/providers/')];
      break;

    case 'country':
      $items[] = ['name' => 'Countries', 'url' => home_url('/countries/')];
      break;

    case 'payment':
      $items[] = ['name' => 'Payments', 'url' => home_url('/payments/')];
      break;

    case 'license':
      $items[] = ['name' => 'Licenses', 'url' => home_url('/licenses/')];
      break;
  }

  $ancestors = array_reverse( get_ancestors( $term->term_id, $taxonomy, 'taxonomy' ) );
  foreach ( $ancestors as $ancestor_id ) {
    $ancestor_term = get_term( $ancestor_id, $taxonomy );
    if ( $ancestor_term && ! is_wp_error( $ancestor_term ) ) {
      $items[] = ['name' => $ancestor_term->name, 'url' => get_term_link( $ancestor_term )];
    }
  }

  $items[] = ['name' => $term->name, 'url' => ''];

  return $items;
}

function get_taxonomy_index_breadcrumbs(): array {
  return [
    ['name' => 'Reviews', 'url' => home_url('/reviews/')],
    ['name' => get_the_title(get_the_ID()), 'url' => ''],
  ];
}

function get_review_type_breadcrumbs($term): array {
  return [
    ['name' => 'Reviews', 'url' => home_url('/reviews/')],
    ['name' => $term->name, 'url' => ''],
  ];
}

function get_bonus_type_breadcrumbs($term): array {
  if (!$term) return [];

  return [
    ['name' => 'Bonuses', 'url' => home_url('/bonuses/')],
    ['name' => $term->name, 'url' => ''],
  ];
}

function get_bonus_breadcrumbs(): array {
  $primary_id = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_bonus_type', true );

  if (!$primary_id) return [];

  $items = [
    ['name' => 'Bonuses', 'url' => home_url('/bonuses/')],
  ];

  $term_link = get_term_link( (int) $primary_id, 'bonus_type' );
  if ( ! is_wp_error( $term_link ) ) {
    $items[] = ['name' => get_term( $primary_id )->name, 'url' => $term_link];
  }

  return $items;
}

/**
 * Single dispatcher used by both the visual breadcrumb template
 * (template-parts/breadcrumbs/breadcrumbs.php) and breadcrumbListSchema()
 * in inc/schemas.php, so both stay in sync from one source of truth.
 */
function get_breadcrumb_items(): array {
  if (is_singular('post')) {
    return get_post_breadcrumbs();
  } else if (is_singular('review')) {
    return get_review_breadcrumbs();
  } else if (is_category()) {
    return get_category_breadcrumbs();
  } else if (is_tax( ['cryptocurrency', 'game', 'provider', 'payment', 'country', 'license'] )) {
    return get_taxonomy_breadcrumbs(get_queried_object());
  } else if (is_tax('review_type')) {
    return get_review_type_breadcrumbs(get_queried_object());
  } else if (is_tax('bonus_type')) {
    return get_bonus_type_breadcrumbs(get_queried_object());
  } else if (is_singular('bonus')) {
    return get_bonus_breadcrumbs();
  } else if (is_page_template( 'templates/taxonomy-index.php' )) {
    return get_taxonomy_index_breadcrumbs();
  }

  return [];
}
