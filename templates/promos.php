<?php /* 
Template Name: Promos 
Template Post Type: post, page
*/  ?>
<?php get_header(); ?>

<div class="container" style="text-align: center; max-width: 900px; margin: 1em auto 2em;">
  <div style="padding: 2em 0;">
    <h1><?php the_title(); ?></h1> 
    <div style="font-size: 1.3rem; max-width: 50ch; margin: 0 auto; margin-top: 1.1rem;"><?php echo wp_kses_post( get_field('promo_introduction') ); ?></div>
  </div>
</div>

<?php $loop_count = 1; ?>
<?php $background_color = '#f9f9f9'; ?>

<?php  if( have_rows('promos') ): ?>
  <div>
  <?php while ( have_rows('promos') ) : the_row(); ?>
  <?php 
    $remainder = $loop_count % 2; 
    if($remainder === 0) {
      $background_color = '#ffffff'; 
    } else {
      $background_color = '#f9f9f9';
    };

    $site = get_sub_field('site');
    $detailsGroup = get_field('details_group', $site);
    $siteName = $detailsGroup['name'];

  ?>


  <div id="section-<?php echo $loop_count; ?>" style="background: <?php echo $background_color; ?>">
    <div class="custom-container" style="padding: 6em 1em; text-align: center; max-width: 600px; margin: 0 auto;">
      <div style="margin-bottom: 1.2em;">
        <img class="border-radius" src="<?php echo get_the_post_thumbnail_url($site); ?>" width="120" height="60" alt="">
      </div>
      <h2 class="h3"><?php echo $siteName; ?></h2>
      <div style="margin-bottom: 1em; font-size: 1.1rem;"><?php echo wp_kses_post(the_sub_field('description')); ?></div>
      <a href="<?php echo wp_kses_post(the_sub_field('link')); ?>" class="button button__primary" rel="nofollow" target="_blank">Claim Bonus</a>
    </div> 
  </div>
  <?php ++$loop_count; ?>
  <?php endwhile; ?>
  </div>
<?php endif; ?>

<!-- featured posts -->
<div class="mb-5">
  <?php featured_articles(); ?>
</div>

<?php get_footer();