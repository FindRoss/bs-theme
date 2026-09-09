<?php

function themebs_enqueue_styles() {

	wp_enqueue_style( 'tailwind-styles', get_template_directory_uri() . '/build/tailwind.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'build-styles', get_template_directory_uri() . '/build/style.css', array(), wp_get_theme()->get('Version'));
  wp_enqueue_style( 'index-styles', get_template_directory_uri() . '/build/index.css', array(), wp_get_theme()->get('Version'));
  // Note: theme root style.css intentionally NOT enqueued here - it only
  // contains the WordPress theme-header comment (no CSS rules), so loading
  // it as a stylesheet was a wasted render-blocking request. The file still
  // exists on disk for WP's theme identification.

	// Use is_singular() rather than a bare get_post_type() here - WordPress
	// sets the global $post to the first result of ANY main query
	// (wp-includes/class-wp.php's $GLOBALS['post'] = $wp_query->post),
	// including archives. On a taxonomy archive, get_post_type() would
	// silently return the post type of whichever post happens to be first
	// in that archive's results, not "are we viewing a single post of this
	// type" - is_singular() checks the latter correctly.
	if ( is_singular( 'bonus' ) ) {
    wp_enqueue_style( 'single-bonus-styles', get_template_directory_uri() . '/build/single-bonus.css', array(), wp_get_theme()->get('Version'));
  }

  if ( is_singular( 'review' ) ) {
    wp_enqueue_style( 'single-review-styles', get_template_directory_uri() . '/build/single-review.css', array(), wp_get_theme()->get('Version'));
  }

  if ( is_singular( array( 'streamer', 'profile' ) ) ) {
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

	if (is_page_template('templates/about-us.php')) {
    wp_enqueue_style( 'about-us-styles', get_template_directory_uri() . '/build/about-us.css', array(), wp_get_theme()->get('Version'));
  }

	if (is_author()) {
    wp_enqueue_style( 'author-styles', get_template_directory_uri() . '/build/author.css', array(), wp_get_theme()->get('Version'));
  }

	if ( is_singular( array( 'review', 'post', 'page' ) ) ) {
    wp_enqueue_style( 'heading-toggle-styles', get_template_directory_uri() . '/build/heading-toggle.css', array(), wp_get_theme()->get('Version'));
  }

	if ( is_singular( array( 'review', 'post', 'bonus' ) ) ) {
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

  if (is_page_template('templates/taxonomy-index.php')) {
    wp_enqueue_style( 'taxonomy-az-index-styles', get_template_directory_uri() . '/build/taxonomy-az-index.css', array(), wp_get_theme()->get('Version'));
  }

  // These 5 are ACF blocks, but in practice they're almost never inserted
  // as blocks - they render via the flexible_content field on taxonomy
  // terms (template-parts/content/flexible-content.php). Only enqueue when
  // the current term's flexible content actually contains that layout.
  // (If one is ever inserted as an actual block instead, ACF/WP already
  // auto-enqueue its style via acf_register_block_type()'s 'enqueue_style'
  // param / block.json's "style" field - no manual check needed here.)
  $flexible_layouts = bs_theme_current_flexible_content_layouts();

  if ( in_array( 'review_info', $flexible_layouts, true ) ) {
    wp_enqueue_style('review-info-styles', get_template_directory_uri() . '/blocks/review-info/review-info.css', array(), wp_get_theme()->get('Version'));
  }
  if ( in_array( 'review_pros_cons', $flexible_layouts, true ) ) {
    wp_enqueue_style('review-pros-cons-styles', get_template_directory_uri() . '/blocks/review-pros-cons/review-pros-cons-main.css', array(), wp_get_theme()->get('Version'));
  }
  if ( in_array( 'review_cta', $flexible_layouts, true ) ) {
    wp_enqueue_style('review-cta-styles', get_template_directory_uri() . '/blocks/review-cta/review-cta-main.css', array(), wp_get_theme()->get('Version'));
  }
  if ( in_array( 'review_bonus', $flexible_layouts, true ) ) {
    wp_enqueue_style('review-bonus-styles', get_template_directory_uri() . '/blocks/review-bonus/review-bonus.css', array(), wp_get_theme()->get('Version'));
  }
  if ( in_array( 'game_info', $flexible_layouts, true ) ) {
    wp_enqueue_style('game-info-styles', get_template_directory_uri() . '/blocks/game-info/game-info-main.css', array(), wp_get_theme()->get('Version'));
  }

  // us-map isn't a block - it only renders on the country taxonomy for the
  // US term and its state/city descendants (bs_theme_is_us_map_term()).
  if ( is_tax() && bs_theme_is_us_map_term( get_queried_object() ) ) {
    wp_enqueue_style('us-map-styles', get_template_directory_uri() . '/template-parts/section/us-map/us-map-main.css', array(), wp_get_theme()->get('Version'));
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

// hreflang-manager's log-style.css only styles a debug overlay gated to
// admins with the "show log" option enabled, but the plugin enqueues it
// on every front-end request. Dequeue it for everyone else to cut a
// render-blocking request that never renders anything.
function themebs_dequeue_hreflang_log_style() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_dequeue_style( 'da_hm_log_style' );
	}
}
add_action( 'wp_enqueue_scripts', 'themebs_dequeue_hreflang_log_style', 100 );

// Load non-critical, below-the-fold plugin stylesheets asynchronously so
// they don't block first paint (loadCSS pattern: media=print swapped to
// all on load, with a <noscript> fallback for no-JS visitors).
function themebs_defer_noncritical_styles( $html, $handle ) {
	$deferred_handles = array(
		'cookie-consent-client-style',
		'geot-css',
		'heading-toggle-styles',
		'message-styles',
		'review-cta-styles',
		'review-bonus-styles',
		'game-info-styles',
		'us-map-styles',
		'review-pros-cons-styles',
		'review-info-styles',
	);

	if ( ! in_array( $handle, $deferred_handles, true ) ) {
		return $html;
	}

	$deferred = preg_replace(
		"/media=['\"]all['\"]/",
		"media='print' onload=\"this.media='all'\"",
		$html
	);

	return $deferred . '<noscript>' . $html . '</noscript>';
}
add_filter( 'style_loader_tag', 'themebs_defer_noncritical_styles', 10, 2 );

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
 * Sync provider/cryptocurrency terms from a review onto its linked bonuses
 */
require get_theme_file_path('/inc/bonus-taxonomy-sync.php');


/**
 * Slider HTML Output
 */
require get_theme_file_path('/inc/swiper.php');

/**
 * Slider HTML Output
 */
require get_theme_file_path('/inc/taxonomy-query.php');

/**
 * Track which user last saved a taxonomy term's ACF fields
 */
require get_theme_file_path('/inc/term-author-tracking.php');

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

/**
 * A-Z Index helpers
 * - Powers the "All [Taxonomy] A-Z" directory section on templates/taxonomy-index.php
 */
require get_template_directory() . '/inc/taxonomy-az-index.php';


// Change time of time picker on bonuses and posts to be in UTC format
add_filter('acf/fields/date_time_picker/format_value', function($value, $post_id, $field) {
    // Convert the date/time to UTC format
    $date = new DateTime($value, new DateTimeZone('UTC'));
    return $date->format('Y-m-d H:i:s'); // Adjust format if needed
}, 10, 3);