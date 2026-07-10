<?php

define( 'BS_HOMEPAGE_CACHE_KEY', 'bs_homepage_content' );

function bs_clear_homepage_cache() {
  delete_transient( BS_HOMEPAGE_CACHE_KEY );
}

add_action( 'save_post_post', 'bs_clear_homepage_cache' );
add_action( 'save_post_review', 'bs_clear_homepage_cache' );
add_action( 'save_post_bonus', 'bs_clear_homepage_cache' );
add_action( 'save_post_streamer', 'bs_clear_homepage_cache' );

add_action( 'acf/save_post', function( $post_id ) {
  if ( $post_id === 'options' ) {
    bs_clear_homepage_cache();
  }
}, 20 );
