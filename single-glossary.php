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
            <?php require locate_template('components/article/meta.php'); ?>
          </div>
        </div>
      </div><!-- style --> 
    </div><!-- .row -->

    <div class="row justify-content-center mb-5">
      <div class="col-12 col-lg-8 content-area">
        <?php if (has_excerpt()) { ?>
            <div class="fs-xlarge text-muted fst-italic"><?php the_excerpt(); ?></div>
          <?php }; ?>
        <div class="main--content">
          <?php the_content(); ?>
          <?php if (get_field('faqs')) { 
            require locate_template('components/article/faqs.php'); 
          }; ?>
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
      <div class="col-12 col-lg-8 content-area pb-5 mb-5 pb-lg-0 mb-lg-0">
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

<?php get_footer(); ?>