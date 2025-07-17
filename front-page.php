<?php get_header();

$used_posts = array();

// 75 posts needed? 
// $all_posts_query = new WP_Query(array(
//   'post_type'      => 'post', 
//   'post_status'    => 'publish',
//   'posts_per_page' => 75, 
//   'meta_query'     => bonus_expired_meta_query()
// ));

// // COPY OF AILB FRONT PAGE CODE
// $top_post = null; 
// $middle_posts = array(); 
// $rest_of_posts = array();

// $all_posts = new WP_Query(array(
//   'post_type' => 'post',
//   'posts_per_page' => 100,
// ));

// if ($all_posts->have_posts()) {
//   $posts = $all_posts->posts;

//   $top_post = $posts[0];
//   $middle_posts = array_slice($posts, 1, 4); 
//   $rest_of_posts = array_slice($posts, 5); 

//   // 1. Get IDs for the "rest" posts
//   $rest_post_ids = wp_list_pluck($rest_of_posts, 'ID');

//   // 2. Get all categories assigned to those posts
//   $rest_terms = wp_get_object_terms($rest_post_ids, 'category', [
//     'fields' => 'all_with_object_id',
//   ]);

//   $categories_by_post = [];
//   foreach ($rest_terms as $term) {
//     $categories_by_post[$term->object_id][] = $term;
//   }

//   // 3. Group posts by primary category slug
//   $posts_by_cat = [];

//   foreach ($rest_of_posts as $post) {
//     $post_id = $post->ID;

//     // Get Yoast Primary Category (if available)
//     $primary_term = null;
//     if (class_exists('WPSEO_Primary_Term')) {
//       $yoast_primary = new WPSEO_Primary_Term('category', $post_id);
//       $primary_term_id = $yoast_primary->get_primary_term();
//       $primary_term = get_term($primary_term_id);

//     }

//     // Fallback to first assigned category
//     if (!$primary_term || is_wp_error($primary_term)) {
//       $primary_term = $categories_by_post[$post_id][0] ?? null;
//     }

//     // Assign post to the category group
//     if ($primary_term) {
//       $slug = $primary_term->slug;
//       $posts_by_cat[$slug][] = $post;
//     }
//   }
// }

$featured_post_args = array(
  'post_type'      => 'post', 
  'posts_per_page' => 4, 
  'meta_query'     => bonus_expired_meta_query()
);
$featured_post_query = new WP_Query( $featured_post_args ); 
?> 

<div class="container">
  
  <section class="lothian-section">
    <h1 class="h2 m-0">Welcome to BitcoinChaser!</h1>
    <p>Discover Bitcoin casino reviews, cryptocurrency sports betting sites, no-deposit bonuses, gambling guides, and more.</p>
  </section>

  <section class="fife-section">
    <div class="grid">
      <?php if ( $featured_post_query->have_posts() ) : ?>
        <?php while ( $featured_post_query->have_posts() ) : $featured_post_query->the_post() ?>
          <div class="grid-item">
            <?php get_template_part('template-parts/card/card', 'beijing'); ?>
            <?php $used_posts[] = get_the_ID(); ?>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
    <!-- Sidebar -->
    <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
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

<!-- GAMBLING NEWS -->
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


<!-- CRYPTOCURRENCY --> 
<!-- <div class="container mt-5 pt-4">
  <section class="p-3 rounded-corners bg-cus-light">
    
    <div class="row">
      <div class="col-12 col-lg-3">
        <h2 class="h4 mt-3">Cryptocurrency Gambling</h2>
        <p class="mt-2">Learn everything you need to know about cryptocurrency gambling and the best casinos where you can play with crypto.</p>
      </div>
      <div class="col-12 col-lg-9">
        tax_pill_loop('cryptocurrency');
      </div>
    </div> 
  </section>
</div> -->

<!-- Spacer -->
<div style="margin-top:3rem"></div>

<?php get_footer(); ?>