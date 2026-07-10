<?php

function bs_clear_mega_menu_cache() {
  $locations = get_nav_menu_locations();
  if ( empty( $locations['sidebar'] ) ) {
    return;
  }

  $menu_items = wp_get_nav_menu_items( $locations['sidebar'] );
  if ( ! $menu_items ) {
    return;
  }

  foreach ( $menu_items as $item ) {
    if ( (int) $item->menu_item_parent === 0 ) {
      delete_transient( 'bs_mega_menu_panel_' . $item->ID );
    }
  }
}

add_action( 'save_post_post', 'bs_clear_mega_menu_cache' );
add_action( 'save_post_bonus', 'bs_clear_mega_menu_cache' );
add_action( 'save_post_review', 'bs_clear_mega_menu_cache' );
add_action( 'acf/save_post', 'bs_clear_mega_menu_cache', 20 );
add_action( 'wp_update_nav_menu', 'bs_clear_mega_menu_cache' );
