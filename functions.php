<?php

function themebs_enqueue_styles() {

	wp_enqueue_style( 'tailwind-styles', get_template_directory_uri() . '/build/tailwind.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'build-styles', get_template_directory_uri() . '/build/style-index.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'index-styles', get_template_directory_uri() . '/build/index.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));

	$post_type = get_post_type();
  
  if ($post_type === 'bonus') {
    wp_enqueue_style( 'single-bonus-styles', get_template_directory_uri() . '/build/single-bonus.css', array(), wp_get_theme()->get('Version'));
  }
  
  if ($post_type === 'review' ) {
    wp_enqueue_style( 'single-review-styles', get_template_directory_uri() . '/build/single-review.css', array(), wp_get_theme()->get('Version'));
  }
  
  if ($post_type === 'streamer' OR $post_type === 'profile') {
    wp_enqueue_style( 'streamer-styles', get_template_directory_uri() . '/build/single-streamer.css', array(), wp_get_theme()->get('Version'));
  }

  if (is_search()) {
    wp_enqueue_style( 'search-styles', get_template_directory_uri() . '/build/search-results.css', array(), wp_get_theme()->get('Version'));
  }

	if (is_page_template('templates/applications.php')) {
    wp_enqueue_style( 'apps-styles', get_template_directory_uri() . '/build/template-apps.css', array(), wp_get_theme()->get('Version'));
  }

	if (is_page_template('templates/crypto-gambling-regulations.php')) {
    wp_enqueue_style( 'crypto-regs-styles', get_template_directory_uri() . '/build/crypto-gambling-regulations.css', array(), wp_get_theme()->get('Version'));
  }

	if ($post_type === 'review' || $post_type === 'post' || $post_type === 'page') {
    wp_enqueue_style( 'heading-toggle-styles', get_template_directory_uri() . '/build/heading-toggle.css', array(), wp_get_theme()->get('Version'));
  }

	if ($post_type === 'review' || $post_type === 'post' || $post_type === 'bonus') {
    wp_enqueue_style( 'message-styles', get_template_directory_uri() . '/build/message.css', array(), wp_get_theme()->get('Version'));
  }

	if (is_404()) {
    wp_enqueue_style( '404-styles', get_template_directory_uri() . '/build/404.css', array(), wp_get_theme()->get('Version'));
	}

  if (is_post_type_archive('review')) {
    wp_enqueue_style( 'archive-review-styles', get_template_directory_uri() . '/build/archive-review.css', array(), wp_get_theme()->get('Version'));
  }

  if (is_front_page()) {
    wp_enqueue_style( 'front-page-styles', get_template_directory_uri() . '/build/front-page.css', array(), wp_get_theme()->get('Version'));
  }

  if (is_tax() || is_page()) {
    wp_enqueue_style('review-info-styles',      get_template_directory_uri() . '/blocks/review-info/review-info.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('review-pros-cons-styles', get_template_directory_uri() . '/blocks/review-pros-cons/review-pros-cons-main.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('review-cta-styles',       get_template_directory_uri() . '/blocks/review-cta/review-cta-main.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('review-bonus-styles',     get_template_directory_uri() . '/blocks/review-bonus/review-bonus.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('game-info-styles',        get_template_directory_uri() . '/blocks/game-info/game-info-main.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('us-map-styles',           get_template_directory_uri() . '/template-parts/section/us-map/us-map-main.css', array(), wp_get_theme()->get('Version'));
  }
}
add_action( 'wp_enqueue_scripts', 'themebs_enqueue_styles');

// Register Blocks (with block.json)
add_action( 'init', 'register_acf_blocks', 5 );
function register_acf_blocks() {
    register_block_type( __DIR__ . '/blocks/bonus' );
		register_block_type( __DIR__ . '/blocks/recommended' );
		register_block_type( __DIR__ . '/blocks/site-latest' );
		register_block_type( __DIR__ . '/blocks/game-info' );
		register_block_type( __DIR__ . '/blocks/content-list' );
}

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


// Hide custom permalinks metabox from all post types
add_action('admin_head', function () {
	echo '<style>
		#custom-permalinks-edit-box {
				display: none !important;
		}
	</style>';
});

// Prevent ACF WYSIWYG (TinyMCE) fields from stealing focus on page load
add_action('admin_footer', function () {
	echo '<script>
		(function () {
			if (typeof tinymce === "undefined") return;
			var pageReady = false;
			setTimeout(function () { pageReady = true; }, 3000);
			var origFocus = tinymce.Editor.prototype.focus;
			tinymce.Editor.prototype.focus = function (skipFocus) {
				if (!pageReady) return;
				return origFocus.apply(this, arguments);
			};
		})();
	</script>';
});

// Widen the ACF fields area on the taxonomy term edit screen
add_action('admin_head-term.php', function () {
	echo '<style>
		.acf-postbox.acf-term-meta-fields {
				max-width: none;
		}
		.acf-postbox.acf-term-meta-fields .acf-field {
				max-width: none;
		}
	</style>';
});

// Include SVG icons
include get_template_directory() . '/assets/svg-icons.php';

function themebs_enqueue_scripts() {
   wp_deregister_script( 'jquery' );
  
  wp_register_script('main-chaser', get_template_directory_uri() . '/build/index.js', [], wp_get_theme()->get('Version'), true);
  wp_enqueue_script('main-chaser');

	if (is_page_template('templates/power-index.php')) {
		wp_enqueue_script('toggle-table', get_template_directory_uri() . '/build/toggle-table.js', [], wp_get_theme()->get('Version'), true); 
	}

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

// if ( defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local' ) {
// add_filter( 'geot/user_ip', 'geot_ip' );
//   function geot_ip( $ip ) {
    // return '206.167.233.1';   // Canada (Rogers)
    // return '81.2.69.142';    // UK
    // return '100.255.255.255'; // US
    // return '217.0.0.1';   
//   }
// };



/* Custom length for the_excerpt */
function custom_excerpt_length( $length ) {
  return 16;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
  


/**
 * Helper functions
 * get_review_faqs()
 * 
 */
require get_theme_file_path('/inc/helper.php');

/**
 * Template functions
 * - terms_to_box
 */ 
require get_theme_file_path('/inc/template-functions.php');

/**
 * Search Endpoint
 */
require get_theme_file_path('/inc/search-endpoint.php');
require get_theme_file_path('/inc/load-more-endpoint.php');

/**
 * Homepage Cache
 * - bs_clear_homepage_cache()
 */
require get_theme_file_path('/inc/homepage-cache.php');

/**
 * Mega Menu Cache
 * - bs_clear_mega_menu_cache()
 */
require get_theme_file_path('/inc/mega-menu-cache.php');

/**
 * Bradcrumbs
 * get_review_breadcrumbs()
 * get_post_breadcrumbs()
 */
require get_theme_file_path('/inc/breadcrumb-getters.php');

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
require get_theme_file_path('/inc/icon-nav-svgs.php');

/**
 * Styled heading
 */
require get_theme_file_path('/inc/styled-heading.php');

/**
 * Schemas
 */
require get_theme_file_path('/inc/schemas.php');

/**
 * US Map data
 */
require get_theme_file_path('/inc/us-map-data.php');

/**
 * Register ACF Blocks
 */
require get_theme_file_path('/inc/acf-blocks.php');

/**
 * Bonuses by review
 */
require get_theme_file_path('/inc/bonuses-by-review.php');


/**
 * Slider HTML Output
 */
require get_theme_file_path('/inc/swiper.php');

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
 * Custom Nav Walker
 */
require get_template_directory() . '/inc/custom-walker.php';
require get_template_directory() . '/inc/acf-menu-fields.php';

/**
 * Taxonomy Paginated Noindex
 * - Noindex paginated taxonomy pages
 * - noindex, follow = "Don't index this page, but still follow the links on it."
 */
require get_template_directory() . '/inc/taxonomy-paginated-noindex.php';


// Change time of time picker on bonuses and posts to be in UTC format
add_filter('acf/fields/date_time_picker/format_value', function($value, $post_id, $field) {
    // Convert the date/time to UTC format
    $date = new DateTime($value, new DateTimeZone('UTC'));
    return $date->format('Y-m-d H:i:s'); // Adjust format if needed
}, 10, 3);