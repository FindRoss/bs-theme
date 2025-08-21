<?php

function themebs_enqueue_styles() {
  wp_enqueue_style( 'build-styles', get_template_directory_uri() . '/build/style-index.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'index-styles', get_template_directory_uri() . '/build/index.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
  
  if (get_post_type() === 'bonus') {
    wp_enqueue_style( 'single-bonus-styles', get_template_directory_uri() . '/build/single-bonus.css', array(), wp_get_theme()->get('Version'));
  }
  
  if (get_post_type() === 'review' ) {
    wp_enqueue_style( 'single-review-styles', get_template_directory_uri() . '/build/single-review.css', array(), wp_get_theme()->get('Version'));
  }
  
  if (get_post_type() === 'streamer') {
    wp_enqueue_style( 'streamer-styles', get_template_directory_uri() . '/build/single-streamer.css', array(), wp_get_theme()->get('Version'));
  }

  if (is_search()) {
    wp_enqueue_style( 'search-styles', get_template_directory_uri() . '/build/search-results.css', array(), wp_get_theme()->get('Version'));
  }
}
add_action( 'wp_enqueue_scripts', 'themebs_enqueue_styles');

function my_admin_block_styles() {
  wp_enqueue_style('my-admin-block-styles', get_stylesheet_directory_uri() . '/build/admin-block-styles.css', array(), wp_get_theme()->get('Version'));
}
add_action( 'enqueue_block_editor_assets', 'my_admin_block_styles' );

function my_theme_setup() {
    // Remove default patterns
    remove_theme_support( 'core-block-patterns' );

    // Add other theme supports
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_image_size('site-small-logo', 200, 100, true);
}
add_action( 'after_setup_theme', 'my_theme_setup' );


// Include SVG icons
include get_template_directory() . '/assets/svg-icons.php';

function themebs_enqueue_scripts() {
   wp_deregister_script( 'jquery' );
  
  wp_register_script('main-chaser', get_template_directory_uri() . '/build/index.js', [], wp_get_theme()->get('Version'), true);
  wp_enqueue_script('main-chaser');

  // Localize script to pass PHP data to JavaScript
  wp_localize_script('main-chaser', 'svgIcons', [
      'hamburger'   => get_svg_icon('hamburger'),
      'close'       => get_svg_icon('close'),
      'search'      => get_svg_icon('search'),
      'chevronDown' => get_svg_icon('chevron-down'),
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



/* Custom length for the_excerpt */
function custom_excerpt_length( $length ) {
  return 16;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
  

/**
 * Bonus Expired Cron Job
 */
// 1. Register the Bonus cron job (once daily)
add_action('init', function () {
	if (!wp_next_scheduled('check_bonus_expiry_cron')) {
		wp_schedule_event(time(), 'daily', 'check_bonus_expiry_cron'); 
	}
});

// 2. Hook function to run when cron job fires
add_action('check_bonus_expiry_cron', 'update_bonus_expired_flags');

function update_bonus_expired_flags() {
	$args = array(
		'post_type'      => 'bonus',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids', 
		'meta_query'     => array(
			array(
				'key'     => 'expiry_date',
				'compare' => 'EXISTS',
			),
		),
	);

	$bonus_ids = get_posts($args);

	foreach ($bonus_ids as $post_id) {
		$expiry_date = get_field('expiry_date', $post_id); // ACF field

		if ($expiry_date) {
			// Convert to timestamp
			$expiry_timestamp = strtotime($expiry_date);
			$is_expired = $expiry_timestamp < time(); // True if date has passed

			// Update ACF field with boolean true/false
			update_field('bonus_expired', $is_expired, $post_id);
		}
	}
}

/**
 * Promotion Expired Cron Job
 */
// 1. Register the Bonus cron job (once daily)
add_action('init', function () {
	if (!wp_next_scheduled('check_promo_expiry_cron')) {
		wp_schedule_event(time(), 'daily', 'check_promo_expiry_cron'); 
	}
});

// 2. Hook function to run when cron job fires
add_action('check_promo_expiry_cron', 'update_promo_expired_flags');

function update_promo_expired_flags() {
	$args = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
    'category_name'  => 'promotions',
		'posts_per_page' => -1,
		'fields'         => 'ids', 
		'meta_query'     => array(
			array(
				'key'     => 'expiry_date',
				'compare' => 'EXISTS',
			),
		),
	);

	$post_ids = get_posts($args);

	foreach ($post_ids as $post_id) {
		$expiry_date = get_field('expiry_date', $post_id); // ACF field

		if ($expiry_date) {
			// Convert to timestamp
			$expiry_timestamp = strtotime($expiry_date);
			$is_expired = $expiry_timestamp < time();

			// Update ACF field with boolean true/false
			update_field('bonus_expired', $is_expired, $post_id);
		}
	}
}



/**
 * Tax Pill Loop
 */
require get_theme_file_path('/inc/tax-pill-loop.php');

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
 * Taxonomy Paginated Noindex
 * - Noindex paginated taxonomy pages
 * - noindex, follow = "Don't index this page, but still follow the links on it."
 */
require get_template_directory() . '/inc/taxonomy-paginated-noindex.php';

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
