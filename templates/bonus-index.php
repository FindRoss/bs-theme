<?php 
/* 
Template Name: Bonus Index
Template Post Type: page
*/ 
?>

<?php get_header(); ?>
<div class="pb-5">

  <div class="container">
    <h1>Bonuses</h1>
    <div class="main--content">
      <?php $introduction = get_field('introduction'); ?>
      <?php echo $introduction; ?>
    </div>
  </div><!-- .container --> 

  <?php 
  $bonus_types = array(
    array(
      'id' => 25488,
      'title' => 'Welcome', 
      'permalink' => site_url('/bonuses/welcome/')
    ),
    array(
      'id' => 25489,
      'title' => 'Cashback', 
      'permalink' => site_url('/bonuses/cashback/')
    ),
    array(
      'id' => 25491,
      'title' => 'No Deposit', 
      'permalink' => site_url('/bonuses/no-deposit/')
    ),
     array(
      'id' => 25486,
      'title' => 'Free Spins', 
      'permalink' => site_url('/bonuses/free-spins/')
    ),
    array(
      'id' => 25501,
      'title' => 'Crypto', 
      'permalink' => site_url('/bonuses/crypto/')
    ),
    array(
      'id' => 25487,
      'title' => 'Deposit', 
      'permalink' => site_url('/bonuses/deposit/')
    ),
    array(
      'id' => 25496,
      'title' => 'Reload', 
      'permalink' => site_url('/bonuses/reload/')
    ),
    array(
      'id' => 25494,
      'title' => 'Sports Betting', 
      'permalink' => site_url('/bonuses/sports/')
    ),
  );

  // Not actually using this right now
  $postsNotIn = array(); 

  foreach ($bonus_types as $type) {
    $args = array(
      'post_type' => 'bonus',
      'posts_per_page' => 8, 
      'post__not_in' => $postsNotIn,
      'tax_query' => array(
        array(
          'taxonomy' => 'bonus_type',
          'field'    => 'id',
          'terms'    => $type['id']
        ),
      ),
      'meta_query' => bonus_expired_meta_query()
    );

    $bonus_query = new WP_Query($args);
    ?>

    <div class="container mt-5"> 
      <section>
        <?php 
          outputNewSlideHTML(array(
            'query'   => $bonus_query,
            'heading' => $type['title'] . ' Bonuses',
            'link'    => $type['permalink']
          ));
        ?> 
      </section> 
    </div>

  <?php }; ?>

    <!-- Main content -->
    <div class="container mt-5">
      <div class="row main--content">
        <div class="col-12 col-lg-8">
          <?php the_content(); ?>
          <!-- FAQS -->
          <?php get_template_part( 'template-parts/content/content-faqs' ); ?>
        </div><!-- .col --> 
      </div>
    </div>

    


</div><!-- padding --> 
<?php get_footer(); ?>