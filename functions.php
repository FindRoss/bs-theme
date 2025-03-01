<?php

function themebs_enqueue_styles() {
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
  wp_enqueue_style( 'build-styles', get_template_directory_uri() . '/build/style-index.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'swiper-styles', get_template_directory_uri() . '/build/index.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
}
add_action( 'wp_enqueue_scripts', 'themebs_enqueue_styles');

include get_template_directory() . '/assets/svg-icons.php';

function themebs_enqueue_scripts() {
  wp_deregister_script( 'jquery' );
  
  wp_register_script('main-chaser', get_template_directory_uri() . '/build/index.js', [], wp_get_theme()->get('Version'), true);
  wp_enqueue_script('main-chaser');

  // Localize script to pass PHP data to JavaScript
  wp_localize_script('main-chaser', 'svgIcons', [
      'hamburger' => get_svg_icon('hamburger'),
      'close'     => get_svg_icon('close'),
      'search'    => get_svg_icon('search')
  ]);
};
add_action( 'wp_enqueue_scripts', 'themebs_enqueue_scripts');

// Enqueue admin script on admin pages for 'review' post type
function themebs_enqueue_admin_script($hook) {
    global $post_type;

    if ($post_type == 'review' && ($hook == 'post-new.php' || $hook == 'post.php')) {
        wp_enqueue_script('custom-admin', get_template_directory_uri() . '/build/admin.js', array(), '1.0', true);
    }
}
add_action('admin_enqueue_scripts', 'themebs_enqueue_admin_script');
  
/**
* Geotargeting Plugin. https://wordpress.org/plugins/geotargeting/
* Filter IP if you are for example in local host
*/

// TW
// 192.192.192.192
// US
// 100.255.255.255
// add_filter( 'geot/user_ip', 'geot_ip');
// function geot_ip( $ip ) {
//   return '100.255.255.255';
// }


// Stop linking my media file wordpress!
add_action( 'after_setup_theme', function() {
  update_option( 'image_default_link_type', 'none' );
});

// Still need for footer menu?
add_action( 'after_setup_theme', 'register_navwalker' );
function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

/* Custom length for the_excerpt */
function custom_excerpt_length( $length ) {
  return 16;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
  
function chaser_featured_images() {
  add_theme_support('post-thumbnails');
  add_image_size('site-small-logo', 200, 100, true);
}
add_action('after_setup_theme', 'chaser_featured_images');

/**
 * Search Endpoint
 */
require get_theme_file_path('/inc/search-endpoint.php');

/**
 * Register widgets
 * - widgets_init
 */
require get_theme_file_path('/inc/widgets.php');

/**
 * Register nav menus
 * - widgets_init
 */
require get_theme_file_path('/inc/nav-menus.php');

/**
 * Styled heading
 */
require get_theme_file_path('/inc/styled-heading.php');

/**
 * Schemas
 */
require get_theme_file_path('/inc/schemas.php');

/**
 * Featued site on homepage
 */
require get_theme_file_path('/inc/featured-site.php');

/**
 * Register ACF Blocks
 */
require get_theme_file_path('/inc/acf-blocks.php');

/**
 * Bonuses by review
 */
require get_theme_file_path('/inc/bonuses-by-review.php');

/**
 * Featured Articles Homepage
 */
require get_theme_file_path('/inc/featured-articles.php');

/**
 * Last Update
 */
require get_theme_file_path('/inc/last-update.php');

/**
 * Language Attributes
 */
require get_theme_file_path('/inc/language-attributes.php');

/**
 * Slider HTML Output
 */
require get_theme_file_path('/inc/swiper.php');

/**
 * Big Slider HTML Output
 */
require get_theme_file_path('/inc/swiper-big.php');

/**
 * Slider HTML Output
 */
require get_theme_file_path('/inc/taxonomy-query.php');

/**
 * Render Filter Overlay
 */
require get_theme_file_path('/inc/render-filter-overlay.php');

/**
 * Render Filter Items
 */
require get_theme_file_path('/inc/render-filter-items.php');

/**
 * Bonus Expired Meta Query
 */
require get_theme_file_path('/inc/bonus-expired-meta-query.php');

/**
 * Custom Nav Walker
 */
require get_template_directory() . '/inc/custom-walker.php';

/**
 * Format Date
 */
function formatDate($date) {
  if ($date) {
    // Create a DateTime object from the string with the new format
    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    
    // Check if the conversion was successful
    if ($dateTime) {
      // Format the date as "j F Y" (e.g., "12 January 2025")
      $formattedDate = $dateTime->format('j F Y');
      
      return $formattedDate;
    } else {
      // Handle invalid input date
      return "Invalid date format";
    }
  }
  // Handle case where no date is provided
  return null;
}


function truncate_text($text, $max_length = 100) {
  if (strlen($text) > $max_length) {
    return substr($text, 0, $max_length) . '...';
  }
  return $text;
};

// Change time of time picker on bonuses and posts to be in UTC format
add_filter('acf/fields/date_time_picker/format_value', function($value, $post_id, $field) {
    // Convert the date/time to UTC format
    $date = new DateTime($value, new DateTimeZone('UTC'));
    return $date->format('Y-m-d H:i:s'); // Adjust format if needed
}, 10, 3);
