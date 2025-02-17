<?php /* 
Template Name: Apps 
Template Post Type: post, page
*/ ?>

<?php get_header(); ?>

<div class="container">

  <!-- TITLE -->
  <div class="row">
    <div class="col-12 col-lg-8">
      <?php get_template_part( 'template-parts/content/content-title' ); ?>
      <?php get_template_part( 'template-parts/content/content-meta' ); ?>
    </div>
  </div>

  <!-- .CONTENT --> 
  <div class="row d-flex justify-content-center">

    <div class="col-12 col-lg-8">

      <?php get_template_part( 'template-parts/content/content-thumbnail' ); ?>
      <?php the_content(); ?>

      <?php // check if the repeater field has rows of data
        if (have_rows('apps')): 
          
          while (have_rows('apps')) : the_row();   

          $title   = get_sub_field('title'); 
          $price   = get_sub_field('price'); 
          $image   = get_sub_field('image');
          $content = get_sub_field('content');
          $website = get_sub_field('website'); ?>

          <div class="row app-row mb-0 mb-md-5 flex-wrap">
            
            <div class="col-12 col-lg-3 app-image-col">
              <img src="<?php echo $image; ?>" alt="<?php echo $title . 'app'; ?>" width="auto" height="200" class="h-auto app-image"/> 
            </div><!-- .col -->

            <div class="col-12 col-lg-9 mb-3 mb-md-0 pt-3 app-content-col">
              <h3 class="mb-3" style="font-weight: bold"><?php echo $title; ?></h3>
              <div class="row">
                <?php if ($website) { ?>
                <div class="col-12 col-md-6 mb-3">        
                  <div class="d-block fs-small text-muted text-uppercase" style="font-family: var(--font-family-heading); font-weight: semi-bold">Website</div>
                  <a href="<?php echo $website; ?>" style="word-break: break-word;" target=_blank><?php echo $website; ?></a>
                </div>
                <?php }; ?>
                <?php if ($price) { ?>
                <div class="col-12 col-md-6 mb-3">
                  <div class="d-block fs-small text-muted text-uppercase" style="font-family: var(--font-family-heading); font-weight: semi-bold">Price</div>
                  <div><?php echo $price; ?></div>
                </div>
                <?php }; ?>
              </div>
              <?php if ($content) { ?><div class="mb-3"><?php echo $content; ?></div><?php } ?>
            </div><!-- .col-->
          </div><!-- .row -->
        <?php endwhile; ?>
      <?php endif; ?>      
    </div><!-- .col --> 

    <div class="col-12 col-lg-4">
      <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
    </div>

  </div><!-- .row -->
</div><!-- .container --> 




<?php get_footer();