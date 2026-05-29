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


<div class="container">
  <?php get_template_part('template-parts/section/latest-posts-review', null, array(
    'exclude' => array($post_id)
  )); ?>
</div>

<?php endwhile; else: ?>
  <div class="container mb-5">
    <div class="alert alert-primary p-5" role="alert">
    There is no post to show.
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>