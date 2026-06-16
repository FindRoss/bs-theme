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


  // ── 3. HTTP Affiliate Link Posts ──────────────────────────────────────────
  $http_link_posts = [
    33249  => 'http://rd.ia.hhg21lhdhye74ixs.com',
    36322  => 'http://rd.ia.hhg21lhdhye74ixs.com',
    41367  => 'http://jetaffs.com',
    438388 => 'http://jetaffs.com (postmeta)',
    8875   => 'http://clickbank / clickbetter',
    41776  => 'http://wlaff247.adsrv',
    44759  => 'http://wlaff247.adsrv',
    49034  => 'http://traffplay.com',
    49243  => 'http://traffplay.com',
    54799  => 'http://partners.mywin24.com',
    54808  => 'http://partners.wintika / vipspel / heavychips',
  ];

  echo '<h2 style="margin-top:2rem">Posts containing HTTP affiliate links</h2>';
  echo '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%">';
  echo '<thead><tr><th>ID</th><th>Title</th><th>Type</th><th>Status</th><th>HTTP Domain</th><th>Actions</th></tr></thead><tbody>';

  foreach ( $http_link_posts as $post_id => $domain ) {
    $post = get_post( $post_id );
    if ( ! $post ) {
      echo '<tr style="background:#fdd">';
      echo '<td>' . $post_id . '</td>';
      echo '<td colspan="4"><em>Post not found</em></td>';
      echo '<td>' . esc_html( $domain ) . '</td>';
      echo '</tr>';
      continue;
    }
    $status_colour = $post->post_status === 'publish' ? '#ffd' : '#eee';
    echo '<tr style="background:' . $status_colour . '">';
    echo '<td>' . $post_id . '</td>';
    echo '<td><a href="' . esc_url( get_permalink( $post_id ) ) . '" target="_blank">' . esc_html( $post->post_title ) . '</a></td>';
    echo '<td>' . esc_html( $post->post_type ) . '</td>';
    echo '<td>' . esc_html( $post->post_status ) . '</td>';
    echo '<td><code>' . esc_html( $domain ) . '</code></td>';
    echo '<td><a href="' . esc_url( get_edit_post_link( $post_id ) ) . '">Edit</a></td>';
    echo '</tr>';
  }

  echo '</tbody></table>';
  echo '<p style="margin-top:0.5rem;font-size:0.85em;color:#666">Yellow = published. Grey = draft/other. Red = post not found in DB.</p>';


  // ── 4. Posts/pages with 'faqs' or 'faqs_heading' ACF fields populated ──────
  echo '<h2 style="margin-top:2rem">Posts / pages with <code>faqs</code> block fields populated</h2>';
  echo '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%">';
  echo '<thead><tr><th>ID</th><th>Title</th><th>Type</th><th>Status</th><th>faqs_heading</th><th>faqs (count)</th><th>Actions</th></tr></thead><tbody>';

  $faqs_query = new WP_Query( [
    'post_type'      => 'any',
    'post_status'    => [ 'publish', 'draft', 'private', 'pending' ],
    'posts_per_page' => -1,
    'meta_query'     => [
      'relation' => 'OR',
      [ 'key' => 'faqs', 'compare' => 'EXISTS' ],
      [ 'key' => 'faqs_heading', 'compare' => 'EXISTS' ],
    ],
  ] );

  if ( $faqs_query->have_posts() ) {
    while ( $faqs_query->have_posts() ) {
      $faqs_query->the_post();
      $pid     = get_the_ID();
      $heading = get_field( 'faqs_heading', $pid );
      $faqs    = get_field( 'faqs', $pid );
      $count   = is_array( $faqs ) ? count( $faqs ) : 0;
      if ( ! $heading && ! $count ) continue;
      $bg = get_post_status() === 'publish' ? '#ffd' : '#eee';
      echo '<tr style="background:' . $bg . '">';
      echo '<td>' . $pid . '</td>';
      echo '<td><a href="' . esc_url( get_permalink() ) . '" target="_blank">' . esc_html( get_the_title() ) . '</a></td>';
      echo '<td>' . esc_html( get_post_type() ) . '</td>';
      echo '<td>' . esc_html( get_post_status() ) . '</td>';
      echo '<td>' . esc_html( $heading ?: '—' ) . '</td>';
      echo '<td>' . $count . '</td>';
      echo '<td><a href="' . esc_url( get_edit_post_link( $pid ) ) . '">Edit</a></td>';
      echo '</tr>';
    }
    wp_reset_postdata();
  } else {
    echo '<tr><td colspan="7"><em>None found.</em></td></tr>';
  }

  echo '</tbody></table>';
  echo '<p style="margin-top:0.5rem;font-size:0.85em;color:#666">Yellow = published. Grey = draft/other.</p>';

  ?>

</div>

<?php get_footer(); ?>