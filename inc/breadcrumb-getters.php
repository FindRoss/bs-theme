<?php

function get_post_breadcrumbs() {
  if (!is_singular('post')) {
      return '';
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
      return '';
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

  $breadcrumb_html = '';
  foreach ($breadcrumb_path as $cat) {
      $cat_link = get_category_link($cat->term_id);
      $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="' . esc_url($cat_link) . '">' . esc_html($cat->name) . '</a></span>';
  }

  return $breadcrumb_html; // always return a string
}
 
function get_category_breadcrumbs(): string {
	if (!is_category()) return '';

	$term = get_queried_object();

	$breadcrumb_html = '';

  if ($term->parent !== 0) {
    $parent_category = get_category($term->parent);

    $parent_cat_name = $parent_category->name;
    $parent_cat_link = get_category_link($parent_category->term_id);

 
    if ($parent_category->parent !== 0) {
      $grandparent_category = get_category($parent_category->parent);

      $grandparent_cat_name = $grandparent_category->name;
      $grandparent_cat_link = get_category_link($grandparent_category->term_id);

      // Add this one first - the grandparent category link to the output
      $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="' . esc_html($grandparent_cat_link) . '">' . esc_html($grandparent_cat_name) . '</a></span>';
    }

    // The parent category link to the output
    $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="' . esc_html($parent_cat_link) . '">' . esc_html($parent_cat_name) . '</a></span>';

    $breadcrumb_html .= '<span class="breadcrumbs__layout--item">' . $term->name . '</span>';
  }

	return $breadcrumb_html;

}

function get_review_breadcrumbs(): string {
  
    if (!is_singular('review')) return '';

    $primary_id = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_review_type', true );
  
    $breadcrumb_html = '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/reviews/">Reviews</a></span>';

    if ($primary_id) {
      $term_link = get_term_link( (int) $primary_id, 'review_type' );
      if (!is_wp_error( $term_link )) {
        $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="' . esc_url( $term_link ) . '">' . esc_html( get_term( $primary_id )->name ) . '</a></span>';
      }
    }

    $breadcrumb_html .= '<span class="breadcrumbs__layout--item">' . get_the_title(get_the_ID()) . '</span>';

    return $breadcrumb_html;
}

function get_taxonomy_breadcrumbs($term) {
  if (!$term) return '';

  $taxonomy = $term->taxonomy;
  $name = $term->name;
  
  $breadcrumb_html = '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/reviews/">Reviews</a></span>';

  switch ( $taxonomy ) {
    case 'cryptocurrency':
      $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/crypto/">Crypto</a></span>';
      break;

    case 'game':
      $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/games/">Games</a></span>';
      break;

    case 'provider':
      $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/providers/">Providers</a></span>';
      break;

    case 'country':
      $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/countries/">Countries</a></span>';
      break;

    case 'payment':
      $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/payments/">Payments</a></span>';
      break;

    default:
      echo "...";
      break;
  }

  $breadcrumb_html .= '<span class="breadcrumbs__layout--item">' . $term->name . '</span>';

  return $breadcrumb_html;
}

function get_taxonomy_index_breadcrumbs() {
  $breadcrumb_html = '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/reviews/">Reviews</a></span>';
  $breadcrumb_html .= '<span class="breadcrumbs__layout--item">' . get_the_title(get_the_ID()) . '</span>';

  return $breadcrumb_html;
}

function get_review_type_breadcrumbs($term) {
  
  $breadcrumb_html = '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/reviews/">Reviews</a></span>';
  $breadcrumb_html .= '<span class="breadcrumbs__layout--item">' . $term->name . '</span>';

  return $breadcrumb_html;
}

function get_bonus_type_breadcrumbs($term) {
  if (!$term) return '';

  $breadcrumb_html = '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/bonuses/">Bonuses</a></span>';
  $breadcrumb_html .= '<span class="breadcrumbs__layout--item">' . $term->name . '</span>';

  return $breadcrumb_html;
}

function get_bonus_breadcrumbs() {
  $primary_id = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_bonus_type', true );

  if (!$primary_id) return '';

  $breadcrumb_html = '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="/bonuses/">Bonuses</a></span>';

  $term_link = get_term_link( (int) $primary_id, 'bonus_type' );
  if ( ! is_wp_error( $term_link ) ) {
    $breadcrumb_html .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="' . esc_url( $term_link ) . '">' . esc_html( get_term( $primary_id )->name ) . '</a></span>';
  }

  // $breadcrumb_html .= '<span class="breadcrumbs__layout--item">' . get_the_title() . '</span>';

  return $breadcrumb_html;
}