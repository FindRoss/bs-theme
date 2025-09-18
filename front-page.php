<?php get_header();

$used_posts = array();

$featured_post_args = array(
  'post_type'      => 'post', 
  'posts_per_page' => 4, 
  'meta_query'     => bonus_expired_meta_query()
);
$featured_post_query = new WP_Query( $featured_post_args ); 

$countries_to_show = [
  'germany', 
  'australia',
  'canada',
  'new zealand',
  'united kingdom',
  'norway',
];

$first_image_bool = true;
?> 

<div class="container">
  
  <section class="lothian-section">
    <h1 class="h2 m-0">Welcome to BitcoinChaser!</h1>
    <p>Discover Bitcoin casino reviews, cryptocurrency sports betting sites, no-deposit bonuses, gambling guides, and more.</p>
  </section>

  <section class="fife-section mt-4">
    <div class="fife-section__content grid">
      <?php if ( $featured_post_query->have_posts() ) : ?>
        <?php while ( $featured_post_query->have_posts() ) : $featured_post_query->the_post() ?>
          
          <div class="grid-item">
            <?php 
              if ($first_image_bool) { 
                // Created this one just so I can have fetchpriority and lazyload css class.
                get_template_part('template-parts/card/card', 'beijing-lcp');
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

<div class="container">
  <section class="slide-section">
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
?>
  
<div class="container mt-5">
  <section class="angus-section">
    <?php 
      $blog_section_query = new WP_Query(array(
        'post_type'      => array('post'), 
        'posts_per_page' => 4, 
        'category_name'  => $blog_section_category,
        'post__not_in'   => $used_posts,
        'meta_query'     => bonus_expired_meta_query()
      )); 
      ?> 
  
      <?php if ( $blog_section_query->have_posts() ) : ?>

        <?php chaser_styled_sub_heading(array(
          'heading' => $blog_section_title,
          'link'    => $blog_section_slug
        )); ?>

        <p><?php echo $blog_section_description; ?></p>

        <div class="layout">
          <?php while ( $blog_section_query->have_posts() ) : $blog_section_query->the_post() ?>
            <div class="grid-item">
              <?php  get_template_part('template-parts/card/card', 'beijing'); ?>
              <?php $used_posts[] = get_the_ID(); ?>
            </div>
          <?php endwhile; ?>

        </div><!-- .row --> 
      <?php wp_reset_postdata();
      endif; ?>
  </section>
</div>

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

<!-- NEWS -->
<?php 
  $latest_casino_news_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'news', 
    'meta_query'     => bonus_expired_meta_query()
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

<!-- BLOCKCHAIN -->
<?php 
  $blockchain_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'blockchain',
    'meta_query'     => bonus_expired_meta_query()
  )); 
  
  $blockchain_foundPosts = $blockchain_query->found_posts;

  if ($blockchain_foundPosts >= 4) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $blockchain_query,
          'heading' => 'Blockchain', 
          'link' => '/category/blockchain/'
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

<!-- CRYPTCURRENCY -->
<?php 
  $cryptocurrency_query = new WP_Query(array( 
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'cryptocurrency',
    'meta_query'     => bonus_expired_meta_query()
  )); 
  
  $cryptocurrency_foundPosts = $cryptocurrency_query->found_posts;

  if ($cryptocurrency_foundPosts >= 4) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query' => $cryptocurrency_query,
          'heading' => 'Cryptocurrency', 
          'link' => '/category/cryptocurrency/'
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
    'meta_query'     => bonus_expired_meta_query()
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

<!-- Spacer -->
<div style="margin-top:3rem"></div>

<?php get_footer(); ?>