<?php

/*
* Keep bonus posts' provider/cryptocurrency terms in sync with their linked casino review.
* The relationship lives on the bonus (ACF field 'single_bonus_casino' -> review), so bonus
* posts don't automatically inherit the review's terms without this.
*/

const BONUS_SYNCED_TAXONOMIES = array( 'provider', 'cryptocurrency' );

function bc_sync_bonus_taxonomies_from_review( $bonus_id, $review_id ) {
  foreach ( BONUS_SYNCED_TAXONOMIES as $taxonomy ) {
    $term_ids = $review_id ? wp_get_object_terms( $review_id, $taxonomy, array( 'fields' => 'ids' ) ) : array();
    if ( ! is_array( $term_ids ) ) $term_ids = array();
    wp_set_object_terms( $bonus_id, $term_ids, $taxonomy );
  }
}

function bc_sync_bonus_taxonomies_on_bonus_save( $post_id ) {
  if ( get_post_type( $post_id ) !== 'bonus' ) return;

  $casino = get_field( 'single_bonus_casino', $post_id );
  $review_id = is_array( $casino ) ? ( $casino[0] ?? null ) : $casino;
  $review_id = is_object( $review_id ) ? $review_id->ID : $review_id;

  bc_sync_bonus_taxonomies_from_review( $post_id, $review_id ?: null );
}
add_action( 'acf/save_post', 'bc_sync_bonus_taxonomies_on_bonus_save', 20 );

function bc_sync_bonus_taxonomies_on_review_save( $post_id ) {
  if ( get_post_type( $post_id ) !== 'review' ) return;
  if ( ! function_exists( 'get_bonuses_by_review_query' ) ) return;

  $query = get_bonuses_by_review_query( $post_id );
  if ( ! $query || ! $query->have_posts() ) return;

  foreach ( $query->posts as $bonus ) {
    bc_sync_bonus_taxonomies_from_review( $bonus->ID, $post_id );
  }
}
add_action( 'acf/save_post', 'bc_sync_bonus_taxonomies_on_review_save', 20 );

/*
* Hide the provider/cryptocurrency taxonomy panels on the Bonus edit screen —
* they're fully derived from the linked review, so editing them directly on a bonus
* would just get overwritten on the next save. The Bonus CPT uses the block editor
* (show_in_rest => true), where taxonomy checkboxes are Gutenberg sidebar panels,
* not classic meta boxes — so this has to run as JS via wp.data, not remove_meta_box().
*/
function bc_hide_synced_bonus_taxonomy_panels() {
  $screen = get_current_screen();
  if ( ! $screen || $screen->post_type !== 'bonus' || ! $screen->is_block_editor() ) return;
  ?>
  <script>
    wp.domReady( function () {
      <?php foreach ( BONUS_SYNCED_TAXONOMIES as $taxonomy ) : ?>
      wp.data.dispatch( 'core/edit-post' ).removeEditorPanel( 'taxonomy-panel-<?php echo esc_js( $taxonomy ); ?>' );
      <?php endforeach; ?>
    } );
  </script>
  <?php
}
add_action( 'admin_footer-post.php', 'bc_hide_synced_bonus_taxonomy_panels' );
add_action( 'admin_footer-post-new.php', 'bc_hide_synced_bonus_taxonomy_panels' );
