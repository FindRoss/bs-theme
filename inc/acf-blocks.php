<?php

/**
 * ACF Blocks
 */

add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {

  // Check function exists.
  if( function_exists('acf_register_block_type') ) {
    /**
    * Casino Details
    */
    acf_register_block_type(array(
      'name'              => 'details',
      'title'             => __('Casino details'),
      'description'       => __('A custom block displaying casino details.'),
      'render_template'   => 'blocks/details/details.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/details/details-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'casino', 'details' ),
      'post_types'        => array( 'post', 'page' ),
      'icon'              =>  'book'
    ));
    /**
    * Casino Card 
    */
    acf_register_block_type(array(
      'name'              => 'Casino card',
      'title'             => __('Casino card'),
      'description'       => __('NEW casino card displaying casino details.'),
      'render_template'   => 'blocks/casino-card/casino-card.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/casino-card/casino-card-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'casino', 'casino card', 'card' ),
      'post_types'        => array( 'post', 'page' ),
      'icon'              => 'media-text'
    ));
    /**
    * Casino CTA 
    */
    acf_register_block_type(array(
      'name'              => 'Casino Call to Action',
      'title'             => __('Casino call to action'),
      'description'       => __('Add a link to a casino.'),
      'render_template'   => 'blocks/casino-cta/casino-cta.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/casino-cta/casino-cta-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'casino', 'cta', 'link', 'call to action' ),
      'post_types'        => array( 'post', 'page', 'bonus' ),
      'icon'              => 'button'
    ));
    /**
    * Casino CTA 
    */
    acf_register_block_type(array(
      'name'              => 'Review Call to Action',
      'title'             => __('Review call to action'),
      'description'       => __('Add a link to a casino.'),
      'render_template'   => 'blocks/review-cta/review-cta.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/review-cta/review-cta-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'review', 'cta', 'link', 'call to action' ),
      'post_types'        => array( 'post', 'page'),
      'icon'              => 'button'
    ));
    /**
    * Casino Read More
    */
    acf_register_block_type(array(
      'name'              => 'more',
      'title'             => __('Casino read more'),
      'description'       => __('A custom block displaying read more or visit for a casino.'),
      'render_template'   => 'blocks/more/more.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/more/more.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'casino', 'more', 'read' ),
      'post_types'        => array( 'post', 'page' ),
      'icon'              => 'excerpt-view'
    ));
    /**
    * Casino List
    */
    acf_register_block_type(array(
      'name'              => 'casino-list',
      'title'             => __('Casino List'),
      'description'       => __('A custom block displaying casinos with links to the casino.'),
      'render_template'   => 'blocks/casino-list/casino-list.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/casino-list/casino-list.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'casino', 'list', 'table' ),
      'post_types'        => array( 'post', 'page' ),
      'icon'              => 'editor-ul'
    ));
     /**
    * Casino List
    */
    acf_register_block_type(array(
      'name'              => 'review-table',
      'title'             => __('Review Table'),
      'description'       => __('A custom block displaying a table of reviews.'),
      'render_template'   => 'blocks/review-table/review-table.php',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'review', 'table', 'list', 'casino' ),
      'post_types'        => array( 'post' ),
      'icon'              => 'editor-ul'
    ));
    /**
    * Bonus
    */
    acf_register_block_type(array(
      'name'              => 'bonus',
      'title'             => __('Bonus'),
      'description'       => __('A custom block displaying a casino bonus.'),
      'render_template'   => 'blocks/bonus/bonus.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/bonus/bonus-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'bonus', 'casino', 'promotion' ),
      'post_types'        => array( 'post', 'page', 'review' ),
      'icon'              => 'star-filled'
    ));
    /**
    * Recommended Article
    */
    acf_register_block_type(array(
      'name'              => 'recommended',
      'title'             => __('Recommend Articles'),
      'description'       => __('A custom block to display posts and bonuses on BitcoinChaser.'),
      'render_template'   => 'blocks/recommended/recommended.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/recommended/recommended-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'recommended', 'recommend', 'read', 'more', 'next', 'article' ),
      'post_types'        => array( 'post', 'page', 'review' ),
      'icon'              => 'star-filled'
    ));
    /**
    * Site latest
    */
    acf_register_block_type(array(
      'name'              => 'site-latest',
      'title'             => __('Site Latest'),
      'description'       => __('A custom block displaying the latest articles or bonuses from a gambling site.'),
      'render_template'   => 'blocks/site-latest/site-latest.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/site-latest/site-latest-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'bonuses', 'posts', 'promos', 'latest', 'site', 'casino', 'gambling', 'news' ),
      'post_types'        => array( 'post', 'page', 'review' ),
      'icon'              => 'star-filled'
    ));
    /**
    * Review Info
    */
    acf_register_block_type(array(
      'name'              => 'review-info',
      'title'             => __('Review Info'),
      'description'       => __('A custom block displaying information from a review.'),
      'render_template'   => 'blocks/review-info/review-info.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/review-info/review-info.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'review', 'casino', 'site', 'info', 'details', 'image' ),
      'post_types'        => array( 'post', 'page' ),
      'icon'              => 'star-filled'
    ));
    /**
    * Review Pros and Cons
    */
    acf_register_block_type(array(
      'name'              => 'review-pros-cons',
      'title'             => __('Review Pros and Cons'),
      'description'       => __('A custom block displaying review pros and cons.'),
      'render_template'   => 'blocks/review-pros-cons/review-pros-cons.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/review-pros-cons/review-pros-cons-main.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'reviews', 'pros', 'cons' ),
      'post_types'        => array( 'post', 'page' ),
      'icon'              => 'star-filled'
    ));
    /**
    * Review Info
    */
    acf_register_block_type(array(
      'name'              => 'review-bonus',
      'title'             => __('Review Bonus'),
      'description'       => __('A custom block displaying bonus from a review.'),
      'render_template'   => 'blocks/review-bonus/review-bonus.php',
      'enqueue_style'     => get_template_directory_uri() . '/blocks/review-bonus/review-bonus.css',
      'mode'              => 'edit',
      'category'          => 'layout',
      'align'             => 'full',
      'keywords'          => array( 'review', 'casino', 'site', 'bonus', 'promo', 'free spins' ),
      'post_types'        => array( 'post', 'page' ),
      'icon'              => 'star-filled'
    ));
  }
};