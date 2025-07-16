<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


<article>
  <div class="container mb-4">

    <div class="row mb-5 pb-4 justify-content-center">
      <div class="col-12 col-lg-8">

        <h1 class="main--title"><?php the_title(); ?></h1>

        <div class="main--content mt-5">
          <?php the_content(); ?>
        </div>

      </div>
    </div><!-- .row --> 
  </div><!-- .container -->
</article>

<?php endwhile; endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>