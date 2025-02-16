<?php 
/* 
Template Name: Glossary
Template Post Type: page
*/ 
?>

<?php get_header(); ?>


<?php 
$glossary_args = array(
  'post_type'      => 'glossary',
  'posts_per_page' => -1,
  'order'          => 'ASC',
  'meta_key'       => 'glossary_term',
  'orderby'        => 'meta_value'
);
$glossary_query = new WP_Query($glossary_args);

?>

<div class="py-5">
  <div class="container">
    <h1><?php the_title(); ?></h1>

    <div class="mt-4">
      <?php the_content(); ?>
    </div>
    
    <?php if ( $glossary_query->have_posts() ) : ?>
      <div class="row mt-4">
        <?php while ( $glossary_query->have_posts() ) : $glossary_query->the_post(); ?>
          <?php $glossary_term = get_field('glossary_term'); ?>

          <div class="col-12 col-lg-6 mb-3">
            <a href="<?php the_permalink(); ?>" class="glossary__card-link">
              <div class="glossary__card p-3">
                <h2><?php echo $glossary_term; ?></h2>
                <?php the_excerpt(); ?>
              </div>
            </a>
          </div>

        <?php endwhile; ?>
      </div><!-- .row --> 
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

  </div><!-- .container --> 
</div>
<?php get_footer(); ?>













