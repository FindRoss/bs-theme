<?php get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

  $categories = get_the_category(); 

  if ( !empty( $categories ) && isset( $categories[0] ) ) {
    $single_category_id = $categories[0]->cat_ID ?? null;
    $single_category_name = $categories[0]->name; 
    $single_category_link = get_category_link( $single_category_id );
  } else {
    $single_category_id = null;
    $single_category_name = '';
    $single_category_link = '';
  }
  
  $post_date = get_the_date( 'M j, Y' );

  $promo_marked_as_expired = get_field('bonus_expired');
  $expiry_date = get_field('expiry_date');
  $expiry_date_has_passed = false;
  $expiry_pill_html = '';  
      
  if ($expiry_date) {
    $expiry_date_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $expiry_date)->getTimestamp();
    $expiry_date_has_passed = $expiry_date_timestamp < time();


    if($expiry_date_has_passed || $promo_marked_as_expired) { 
      get_template_part( 'template-parts/message/message-expired' );
    } else {
      $expiry_timestamp = $expiry_date ? strtotime($expiry_date) * 1000 : 'Expired';

      ob_start(); ?>
        <span class="info-pill info-pill-expiry timer" data-expiry="<?php echo esc_attr( $expiry_timestamp ); ?>">
          <?php echo get_svg_icon('stopwatch'); ?>
          <span class="ends-in-text"></span>
        </span>
      <?php
      $expiry_pill_html = ob_get_clean();
    }
  }
  ?>

    <?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?> 


    <article>
      <div class="container">
        <!-- TITLE -->
        <div class="row">
          <div class="col-12 col-lg-8">
           
            <!-- <a href="echo $single_category_link" class="cat-pill">$single_category_name;</a> -->
            
            <?php get_template_part( 'template-parts/content/content-title' ); ?>
            <!-- <?php echo $expiry_pill_html; ?> -->
            <?php get_template_part( 'template-parts/content/content-meta' ); ?>
            
          </div>
        </div>

        <div class="row mb-5">
          <div class="col-12 col-lg-8">

           <?php get_template_part( 'template-parts/content/content-thumbnail' ); ?>

            <!-- CONTENT -->
            <div class="main--content">
              <?php the_content(); ?>
              <!-- FAQS -->
              <?php get_template_part( 'template-parts/content/content-faqs' ); ?>
            </div>

          </div><!-- .col -->

          <!-- SIDEBAR -->
          <div class="col-12 col-lg-4 d-flex flex-column">
            <aside class="sidebar">
              <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
            </aside>
          </div>

        </div><!-- .row -->
      </div><!-- .container -->
    </article>


<!-- RELATED ARTICLES --> 
<?php 
  $current_post_id = get_the_ID();
  $args = array(
    'post_type'      => 'post', 
    'post__not_in'   => array($current_post_id),
    'posts_per_page' => 8, 
    'cat'            => $single_category_id,
    'meta_query'     => bonus_expired_meta_query()
    
  ); 
  $latest_query = new WP_Query( $args );
?>

<?php if ( $latest_query->have_posts() ) : ?>  
  <aside class="container mt-5 pt-4">
    <section>
      <?php outputNewSlideHTML(array(
          'query'   => $latest_query,
          'heading' => $single_category_name,
          'link'    => $single_category_link
        ));
      ?>
    </section>
  </aside>
<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php endwhile; else: ?>
  <div class="container mb-5">
    <div class="alert alert-primary p-5" role="alert">
    There is no post to show.
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>