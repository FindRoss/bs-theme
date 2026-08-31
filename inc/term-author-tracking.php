<?php

function bs_track_term_last_updated_by( $post_id ) {
  if ( ! is_string( $post_id ) || strpos( $post_id, 'term_' ) !== 0 ) {
    return;
  }

  $term_id = (int) str_replace( 'term_', '', $post_id );
  if ( ! $term_id ) {
    return;
  }

  update_term_meta( $term_id, '_bs_term_updated_by', get_current_user_id() );
  update_term_meta( $term_id, '_bs_term_updated_at', current_time( 'mysql' ) );
}
add_action( 'acf/save_post', 'bs_track_term_last_updated_by', 20 );
