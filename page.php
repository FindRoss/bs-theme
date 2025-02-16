<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<style>
  @media screen and (min-width: 992px) {
    .image-border-left {
      border-left: 1px solid #dee2e6 !important;
    }
  }
</style>

<article>
  <div class="container mb-3">
    
    <div class="mb-0 mb-md-4 pb-4 pb-md-4 border-bottom">
      <div class="row">
        <div class="col-12 col-lg-4 d-flex flex-column justify-content-center">
          <h1 class="main--title"><?php the_title(); ?></h1>
          <div class="mb-4">
            <!-- meta --> 
            <?php get_template_part( 'template-parts/content/content-meta' ); ?>
          </div>
        </div>
        <div class="col-12 col-lg-8">
          <img class="w-100 h-auto image-border-left" width="800" height="480" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /> 
        </div>
      </div>
    </div>

    <div class="row mb-5 pb-4 justify-content-center">
      <div class="col-12 col-lg-8">
        <div class="main--content">
          <?php the_content(); ?>
        </div>
      </div>
    </div><!-- .row --> 
  </div><!-- .container -->
</article>
<?php endwhile; endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>