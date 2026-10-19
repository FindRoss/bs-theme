<?php

// Bumping the version makes every cached ranking key unreachable; old transients expire on their own.
function bs_clear_taxonomy_query_cache() {
  update_option( 'bs_tax_q_version', time() );
}

add_action( 'save_post_review', 'bs_clear_taxonomy_query_cache' );

add_action( 'before_delete_post', function( $post_id ) {
  if ( 'review' === get_post_type( $post_id ) ) {
    bs_clear_taxonomy_query_cache();
  }
} );

add_action( 'set_object_terms', function( $object_id ) {
  if ( 'review' === get_post_type( $object_id ) ) {
    bs_clear_taxonomy_query_cache();
  }
} );

// Priority 20 so ACF has already written rank / details_group_closed.
add_action( 'acf/save_post', function( $post_id ) {
  $is_review = is_numeric( $post_id ) && 'review' === get_post_type( (int) $post_id );
  $is_term   = is_string( $post_id ) && 0 === strpos( $post_id, 'term_' );

  if ( $is_review || $is_term ) {
    bs_clear_taxonomy_query_cache();
  }
}, 20 );
