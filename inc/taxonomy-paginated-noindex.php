<?php 
/**
 * Noindex paginated taxonomy archives.
 */

add_filter('wpseo_robots', function($robots) {
  if (is_tax() || is_tag() || is_category()) {
    if (is_paged()) {
      return 'noindex,follow'; // For paginated taxonomy pages
    }
    return 'index,follow'; // For root taxonomy pages
  }
  return $robots;
});
