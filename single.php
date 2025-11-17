<?php get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

  $post_id = get_the_ID();

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
  

  // Really? 
  // $post_date = get_the_date( 'M j, Y' );

  
  $promo_marked_as_expired = get_field('bonus_expired');
  $expiry_date = get_field('expiry_date');
  // $expiry_date_has_passed = false;

  show_banner_message($post_id);
      
  ?>

    <?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?> 

    <article>
      <div class="container">
        <!-- TITLE -->
        <div class="row">
          <div class="col-12 col-lg-8">    
            <?php get_template_part( 'template-parts/content/content-title' ); ?>
            <?php get_template_part( 'template-parts/content/content-author' ); ?>
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
  $args = array(
    'post_type'      => 'post', 
    'post__not_in'   => array($post_id),
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