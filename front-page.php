<?php get_header();

$used_posts = array();

$featured_post_args = array(
  'post_type'      => 'post', 
  'posts_per_page' => 4, 
);
$featured_post_query = new WP_Query( $featured_post_args ); 
 
$first_image_bool = true;
?> 

<div class="container">

  <section class="lothian-section mt-4">
    <h1 class="h2 m-0">Welcome to BitcoinChaser!</h1>
    <p>Discover Bitcoin casino reviews, cryptocurrency sports betting sites, no-deposit bonuses, gambling guides, and more.</p>
  </section>

  <section class="fife-section mt-4">
    <div class="fife-section__content grid-layout">
      <?php if ( $featured_post_query->have_posts() ) : ?>
        <?php while ( $featured_post_query->have_posts() ) : $featured_post_query->the_post() ?>
          
          <div class="grid-item">
            <?php 
              if ($first_image_bool) { 
                get_template_part('template-parts/card/card', 'beijing', array('exclude_lazyload' => true));
              } else { 
                get_template_part('template-parts/card/card', 'beijing'); 
              }; 
            ?>   
          </div>
          
          <?php 
            $used_posts[] = get_the_ID(); 

            if (count($used_posts) > 1) {
              $first_image_bool = false; 
            };
          ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
    <aside class="fife-section__sidebar sidebar">
      <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
    </aside>
  </section><!-- .fife-section -->

</div><!-- .container -->

<!-- BONUSES -->
<?php 
  $bonus_ids_to_include = get_field('bonuses', 'options');

  $featured_bonus_args = array( 
    'post_type'      => 'bonus', 
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'meta_query'     => bonus_expired_meta_query()
  );
  
  if ($bonus_ids_to_include) {
    $featured_bonus_args['post__in'] = $bonus_ids_to_include;
    $featured_bonus_args['orderby']  = 'post__in';
  };
  
$featured_bonus_query = new WP_Query($featured_bonus_args); 
$featured_bonus_foundPosts = $featured_bonus_query->found_posts;

if ($featured_bonus_foundPosts >= 1) { ?>

<div class="container mt-5 pt-4">
  <section>
    <?php 
      outputNewSlideHTML(array(
        'query' => $featured_bonus_query,
        'heading' => 'Exclusive Bonuses', 
        'link' => 'https://bitcoinchaser.com/bonuses/'
      )); 
    ?>
  </section>
</div>

<?php }; ?>

<!-- NEWS -->
<?php 
  $latest_casino_news_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'news', 
  )); 
  
  $latest_casino_news_foundPosts = $latest_casino_news_query->found_posts;

  if ($latest_casino_news_foundPosts >= 8) { ?>


  <div class="container mt-5 pt-4">
    <section>
      <?php 
         outputNewSlideHTML(array(
          'query' => $latest_casino_news_query,
          'heading' => 'News', 
          'link' => '/category/news/'
        )); 
      ?>
    </section>
  </div>
<?php }; ?>

<!-- PROMOTIONS -->
<?php
  $promotions_query = new WP_Query(array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'promotions',
    'meta_query'     => bonus_expired_meta_query()
  ));

  $promotions_foundPosts = $promotions_query->found_posts;

  if ($promotions_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php
        outputNewSlideHTML(array(
          'query'   => $promotions_query,
          'heading' => 'Promotions',
          'link'    => '/category/promotions/'
        ));
      ?>
    </section>
  </div>

<?php }; ?>



<!-- SPORTS -->
<?php 
  $latest_sports_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'sports', 
    'meta_query'     => bonus_expired_meta_query()
  )); 

  $latest_sports_foundPosts = $latest_sports_query->found_posts;

  if ($latest_sports_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $latest_sports_query,
          'heading' => 'Sports', 
          'link' => '/category/sports/'
        ))
      ?>
    </section>
  </div>
<?php }; ?>


<!-- ALTERNATIVES -->
<?php 
  $alternatives_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'alternatives'
  )); 
  
  $alternatives_foundPosts = $alternatives_query->found_posts;

  if ($alternatives_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $alternatives_query,
          'heading' => 'Alternatives', 
          'link' => '/category/alternatives/'
        ));
      ?>
    </section>
  </div>

<?php }; ?>

<!-- BITCOIN CASINOS -->
<?php
  $top_sites = get_field('sites', 'option');

  if ($top_sites) {
    $bitcoin_casinos_query = new WP_Query(array(
      'post_type'      => 'review',
      'post_status'    => 'publish',
      'posts_per_page' => 8,
      'meta_key'       => 'rank', 
      'orderby'        => 'meta_value_num',
      'order'          => 'ASC',
    ));

    if ($bitcoin_casinos_query->have_posts()) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php
        outputNewSlideHTML(array(
          'query'   => $bitcoin_casinos_query,
          'heading' => 'Bitcoin Casinos',
          'link'    => '/sites/casino/'
        ));
      ?>
    </section>
  </div>

    <?php };
  };
?>

<!-- Spacer -->
<div style="margin-top:3rem"></div>

<?php get_footer(); ?>