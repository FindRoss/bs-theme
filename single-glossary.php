<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="container"> 
  <article>

    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">
        <div class="">
          <div class="mb-3">
            <a class="cat-pill" href="/glossary/">Glossary</a>
          </div>
          <h1 class="main--title mb-4"><?php the_title(); ?></h1>
          <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
            <!-- meta --> 
            <?php get_template_part( 'template-parts/content/content-meta' ); ?>
          </div>
        </div>
      </div><!-- style --> 
    </div><!-- .row -->

    <div class="row justify-content-center mb-5">
      <div class="col-12 col-lg-8">
        <?php if (has_excerpt()) { ?>
            <div class="fs-xlarge text-muted fst-italic"><?php the_excerpt(); ?></div>
          <?php }; ?>
        <div class="main--content">
          <?php the_content(); ?>
          <?php get_template_part( 'template-parts/content/content-faqs' ); ?>
        </div>
      </div><!-- .col --> 
    </div><!-- .row --> 
  </article>
</div><!-- .container --> 

<?php endwhile; ?>
<?php endif; ?>

<?php 
  $further_reading_posts = get_field('further_reading');
?>

<?php if ($further_reading_posts) { ?>
  <div class="container">
    <div class="row justify-content-center pb-5 mb-5">
      <div class="col-12 col-lg-8 pb-5 mb-5 pb-lg-0 mb-lg-0">
        <h3 class="border-top pt-3">Further Reading</h3>
        <ul class="">
          <?php foreach ($further_reading_posts as $p) : ?>
            <li><a class="fs-large" href="<?php echo get_the_permalink($p); ?>"><?php echo get_the_title($p) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
<?php }; ?>

<!-- MORE -->
<!-- get_template_part( 'template-parts/section/articles' ); -->

<?php get_footer(); ?>