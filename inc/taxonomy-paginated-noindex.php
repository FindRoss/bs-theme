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

  if (is_post_type_archive('review') && is_paged()) {
    return 'noindex,follow'; // For paginated review archive pages
  }

  if (is_page_template('templates/slot-reviews.php') && is_paged()) {
    return 'noindex,follow'; // For paginated slot-reviews listing template
  }

  return $robots;
});
