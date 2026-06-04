<?php
/*
Template Name: Testing
Template Post Type: page
*/
get_header();

if ( ! current_user_can( 'manage_options' ) ) {
  wp_die( 'Not allowed.' );
}
?>

<div class="container" style="padding: 2rem 0 4rem;">
  <h1>ACF Field Audit</h1>

  <?php

  // ── 1. Taxonomy terms with 'casinos' (post object field, returns post IDs) ──
  $taxonomy_names = [ 'cryptocurrency', 'game', 'provider', 'payment', 'country', 'review_type' ];

  echo '<h2 style="margin-top:2rem">Taxonomy terms with <code>casinos</code> assigned</h2>';
  echo '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%">';
  echo '<thead><tr><th>Taxonomy</th><th>Term</th><th>Casino IDs</th><th>Count</th></tr></thead><tbody>';

  $found_any = false;
  foreach ( $taxonomy_names as $tax ) {
    $terms = get_terms( [ 'taxonomy' => $tax, 'hide_empty' => false ] );
    if ( is_wp_error( $terms ) ) continue;
    foreach ( $terms as $term ) {
      $casinos = get_field( 'casinos', $term );
      if ( ! empty( $casinos ) ) {
        $found_any = true;
        $casino_ids = array_map( fn( $c ) => is_object( $c ) ? $c->ID : (int) $c, (array) $casinos );
        echo '<tr>';
        echo '<td>' . esc_html( $tax ) . '</td>';
        echo '<td><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a> (ID: ' . $term->term_id . ')</td>';
        echo '<td>' . esc_html( implode( ', ', $casino_ids ) ) . '</td>';
        echo '<td>' . count( $casino_ids ) . '</td>';
        echo '</tr>';
      }
    }
  }

  if ( ! $found_any ) {
    echo '<tr><td colspan="4"><em>None found.</em></td></tr>';
  }

  echo '</tbody></table>';


  // ── 2. Categories with 'featured' posts assigned ──────────────────────────
  echo '<h2 style="margin-top:2rem">Categories with <code>featured</code> assigned</h2>';
  echo '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%">';
  echo '<thead><tr><th>Category</th><th>Featured Post IDs</th><th>Count</th></tr></thead><tbody>';

  $categories = get_terms( [ 'taxonomy' => 'category', 'hide_empty' => false ] );
  $found_any  = false;

  foreach ( $categories as $cat ) {
    $featured = get_field( 'featured', $cat );
    if ( ! empty( $featured ) ) {
      $found_any = true;
      $featured_ids = array_map( fn( $p ) => is_object( $p ) ? $p->ID : (int) $p, (array) $featured );
      echo '<tr>';
      echo '<td><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a> (ID: ' . $cat->term_id . ')</td>';
      echo '<td>' . esc_html( implode( ', ', $featured_ids ) ) . '</td>';
      echo '<td>' . count( $featured_ids ) . '</td>';
      echo '</tr>';
    }
  }

  if ( ! $found_any ) {
    echo '<tr><td colspan="3"><em>None found.</em></td></tr>';
  }

  echo '</tbody></table>';

  ?>

</div>

<?php get_footer(); ?>