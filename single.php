<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php 
  $categories = get_the_category(); 
  $single_category_id = $categories[0]->cat_ID; 
  $single_category_name = $categories[0]->name; 
  $single_category_link = get_category_link($single_category_id);
  
  $post_date = get_the_date( 'M j, Y' );

  $promo_marked_as_expired = get_field('bonus_expired');
  $expiry_date = get_field('expiry_date');
  $expiry_date_has_passed = false;
      
  if ($expiry_date) {
    $expiry_date_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $expiry_date)->getTimestamp();
    $expiry_date_has_passed = $expiry_date_timestamp < time();
  }
?>

<?php if($expiry_date_has_passed || $promo_marked_as_expired) { ?>
  <?php get_template_part( 'template-parts/message/message-expired' ); ?>
<?php } ?>

<article class="mt-4">
  <div class="container"> 
    
    <!-- TITLE -->
    <div class="row">
      <div class="col-12 col-lg-8">
        <h1 class="main--title mb-4"><?php the_title(); ?></h1>
        <?php if (has_excerpt()) : ?><div class="main--excerpt mb-4"><?php the_excerpt(); ?></div><?php endif; ?>
        <?php require locate_template('components/article/meta.php'); ?>
      </div>
    </div>

  
    <div class="row mb-5">
      <div class="col-12 col-lg-8">

        <?php if (has_post_thumbnail()) : ?>
          <picture>
            <!-- Large image for desktop -->
            <source media="(min-width: 768px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>">
            <!-- Medium image for mobile -->
            <source media="(max-width: 767px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>">
            <!-- Fallback for browsers that don't support <picture> -->
            <img class="w-100 h-auto border box-shadow-sm my-4 rounded-corners" 
                src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" 
                alt="<?php the_title_attribute(); ?>" 
                title="<?php the_title_attribute(); ?>" />
          </picture>
        <?php endif; ?>

        <!-- CONTENT --> 
        <div class="main--content">
          <?php the_content(); ?>

          <?php 
          // Check if the template is 'applications'
          if (is_page_template('applications.php')) {
            // Add your specific code for 'applications' template here
          }
          ?>

          <?php if (get_field('faqs')) { require locate_template('components/article/faqs.php'); }; ?>
        </div>

      </div><!-- .col --> 

      <!-- SIDEBAR -->
      <div class="col-12 col-lg-4 d-flex flex-column">
        <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
      </div>

    </div><!-- .row --> 
  </div><!-- .container --> 
</main>


<!-- RELATED ARTICLES --> 
<?php 
  $current_post_id = get_the_ID();
  $args = array(
    'post_type'      => 'post', 
    'post__not_in'   => array($current_post_id),
    'posts_per_page' => 8, 
    'cat'            => $single_category_id,
    
  ); 
  $latest_query = new WP_Query( $args );
?>

<?php if ( $latest_query->have_posts() ) : ?>  
  <div class="container mt-5 pt-4">
    <section>
      <?php 
        outputNewSlideHTML(array(
          'query'   => $latest_query,
          'heading' => $single_category_name,
          'link'    => $single_category_link
        ));
      ?>
    </section>
  </div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php featured_articles(); ?>

<?php endwhile; else: ?>
  <div class="container mb-5">
    <div class="alert alert-primary p-5" role="alert">
    There is no post to show.
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>