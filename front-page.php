<?php get_header();

$used_posts = array();

$featured_post_args = array(
  'post_type'      => 'post', 
  'posts_per_page' => 4, 
  'meta_query'     => bonus_expired_meta_query()
);
$featured_post_query = new WP_Query( $featured_post_args ); 
?> 

<div class="container mb-5">
  <div class="row">
    <div class="col-12 col-lg-8">
      <?php if ( $featured_post_query->have_posts() ) : ?>
        <div class="row">
        <?php while ( $featured_post_query->have_posts() ) : $featured_post_query->the_post() ?>
          <div class="col-12 col-sm-6 mt-4">
            <?php require locate_template('components/card/article.php'); ?>
            <?php $used_posts[] = get_the_ID(); ?>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
      <?php endif; ?>
    </div>

    <div class="col-12 col-lg-4">
      <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
    </div><!-- .col --> 
  </div><!-- .row --> 
</div><!-- .container -->


<!-- REVIEWS -->
<?php 
$review_ids_to_include = get_field('reviews', 'options');

$review_args = array(
    'post_type'      => 'review', 
    'post_status'    => 'publish',
    'posts_per_page' => 12, 
); 

if ($review_ids_to_include) {
    $review_args['post__in'] = $review_ids_to_include;
    $review_args['orderby']  = 'post__in';
};

$review_query = new WP_Query($review_args); 
$review_query_foundPosts = $review_query->found_posts;

if ($review_query_foundPosts >= 1) { ?>

<div class="container mt-5 pt-4">
  <section>
    <?php 
      outputNewSlideHTML(array(
        'query'   => $review_query,
        'heading' => 'Featured Reviews'
      )); 
    ?>
  </section>
</div>

<?php }; ?>

<!-- PROMOTIONS -->
<?php 
  $blog_section_category = 'promotions'; 
  $blog_section_title = 'Promotions';
  $blog_section_slug = '/category/promotions/';
  $blog_section_description = 'Get involved in the latest events and promotions running at crypto gambling sites.';
  $blog_section_link_text = 'All Promotions';
  
  require locate_template('components/homepageSection.php');
?>

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
        'heading' => 'Bonuses', 
        'link' => 'https://bitcoinchaser.com/bonuses/'
      )); 
    ?>
  </section>
</div>

<?php }; ?>

<!-- GAMBLING NEWS -->
<?php 
  $latest_casino_news_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'news', 
    // 'meta_query'     => bonus_expired_meta_query()
  )); 
  
  $latest_casino_news_foundPosts = $latest_casino_news_query->found_posts;

  if ($latest_casino_news_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
         outputNewSlideHTML(array(
          'query' => $latest_casino_news_query,
          'heading' => 'Gambling News', 
          'link' => '/category/news/'
        )); 
      ?>
    </section>
  </div>

<?php }; ?>

<?php featured_site_section(); ?>

<?php featured_articles(); ?>

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

<!-- ESPORTS -->
<?php 
  $latest_esports_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'esports',
    'meta_query'     => bonus_expired_meta_query()
  )); 
  
  $latest_esports_foundPosts = $latest_esports_query->found_posts;

  if ($latest_esports_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $latest_esports_query,
          'heading' => 'Esports', 
          'link' => '/category/esports/'
        ));
      ?>
    </section>
  </div>

<?php }; ?>

<!-- Casino Games -->
<?php 
  $latest_games_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'best-games', 
    //  'meta_query'     => bonus_expired_meta_query()
  )); 
  
  $latest_games_foundPosts = $latest_games_query->found_posts;

  if ($latest_games_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $latest_games_query,
          'heading' => 'Casino Games', 
          'link' => '/category/best-games/'
        ));
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
    'category_name'  => 'alternatives',
    // 'meta_query'     => bonus_expired_meta_query()
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

<!-- Big Wins -->
<?php 
  $big_wins_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'big-wins',
    // 'meta_query'     => bonus_expired_meta_query()
  )); 
  
  $big_wins_foundPosts = $big_wins_query->found_posts;

  if ($big_wins_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $big_wins_query,
          'heading' => 'Big Wins', 
          'link' => '/category/big-wins/'
        ));
      ?>
    </section>
  </div>

<?php }; ?>

<!-- STREAMERS -->
<?php 
  $latest_streamer_query = new WP_Query(array( 
    'post_type'      => 'streamer',
    'posts_per_page' => 8
  )); 
  
  $latest_streamer_foundPosts = $latest_streamer_query->found_posts;

  if ($latest_streamer_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $latest_streamer_query,
          'heading' => 'Streamers', 
          'link' => '/streamers/'
        ));
      ?>
    </section>
  </div>

<?php }; ?>

<!-- CRYPTOCURRENCY --> 
<div class="container mt-5 pt-4">
  <section class="p-3 rounded-corners bg-cus-light">
    
    <div class="row">
      <div class="col-12 col-lg-3">
        <h2 class="h4 mt-3">Cryptocurrency Gambling</h2>
        <p class="mt-2">Learn everything you need to know about cryptocurrency gambling and the best casinos where you can play with crypto.</p>
      </div>
      <div class="col-12 col-lg-9">
        <?php $tax = 'cryptocurrency'; ?>
        <?php require locate_template('components/card/tax-pill-loop.php'); ?>
      </div>
    </div><!-- .row --> 
  </section>
</div>

<!-- GAMES -->
<div class="container mt-5 pt-4 mb-5">
  <section class="p-3 rounded-corners bg-cus-light">
    <div class="row">
      <div class="col-12 col-lg-3">
        <h2 class="h4 mt-3">Casino Games</h2>
        <p class="mt-2">Discover the best crypto gambling sites to play your favorite casino games.</p>
      </div>
      <div class="col-12 col-lg-9">
        <?php $tax = 'game'; ?>
        <?php require locate_template('components/card/tax-pill-loop.php'); ?>
      </div>
    </div><!-- .row --> 
  </section>
</div>

<?php get_footer(); ?>