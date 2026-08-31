<?php

/**
 * Snapshot a term's ACF field values before ACF writes the new ones,
 * so the priority-20 hook below can tell whether anything actually changed.
 */
function bs_capture_term_fields_before_save( $post_id ) {
  if ( ! is_string( $post_id ) || strpos( $post_id, 'term_' ) !== 0 ) {
    return;
  }

  $term_id = (int) str_replace( 'term_', '', $post_id );
  if ( ! $term_id ) {
    return;
  }

  $GLOBALS['bs_term_fields_before_save'][ $term_id ] = get_fields( $post_id );
}
add_action( 'acf/save_post', 'bs_capture_term_fields_before_save', 5 );

/**
 * Only bump the "last updated" meta when a field value actually changed.
 * Re-saving a term without editing anything must not refresh the date —
 * Google flags artificially refreshed dates as a manipulation pattern.
 */
function bs_track_term_last_updated_by( $post_id ) {
  if ( ! is_string( $post_id ) || strpos( $post_id, 'term_' ) !== 0 ) {
    return;
  }

  $term_id = (int) str_replace( 'term_', '', $post_id );
  if ( ! $term_id ) {
    return;
  }

  $fields_before = $GLOBALS['bs_term_fields_before_save'][ $term_id ] ?? null;
  $fields_after  = get_fields( $post_id );

  if ( wp_json_encode( $fields_before ) === wp_json_encode( $fields_after ) ) {
    return;
  }

  update_term_meta( $term_id, '_bs_term_updated_by', get_current_user_id() );
  update_term_meta( $term_id, '_bs_term_updated_at', current_time( 'mysql' ) );
}
add_action( 'acf/save_post', 'bs_track_term_last_updated_by', 20 );
