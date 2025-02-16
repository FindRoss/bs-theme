<?php 
/* 
Template Name: Christmas Calendar
Template Post Type: post, page
*/ 
?>
<?php get_header(); ?>


<div class="container mb-3">

  <div class="mb-0 mb-md-4 pb-4 pb-md-4 border-bottom">
    <div class="row">
      <div class="col-12 col-lg-4 d-flex flex-column justify-content-center">
        <h1 class="main--title"><?php the_title(); ?></h1>
        <div class="mb-4">
          <!-- meta --> 
          <?php require locate_template('components/article/meta.php'); ?>
        </div>
      </div>
      <div class="col-12 col-lg-8">
        <img class="w-100 h-auto image-border-left" width="800" height="480" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /> 
      </div>
    </div>
  </div>

  <div class="row mb-5 justify-content-center">
    <div class="col-12 col-lg-8">
      <div class="main--content">
        <?php the_content(); ?>
      </div>
    </div>
  </div><!-- .row --> 

</div><!-- .container -->

<div class="container mb-3">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8">
      

  <?php 
  // date - CHANGE
  $date_today = date('j');
  // $date_today = 5;
  $christmas_emoji_col = Array('✨', '☃️', '🔔',  '⭐', '🧝', '🎅', '🤶', '🍷', '🥛', '🍪', '🦌', '🎄', '🔥', '🎁', '🧦', '🌠', '🎶', '🕯️', '❄️', '🔔',  '⭐', '🥛 ', '🎁', '🦌', '🍪', '🎅'); 

  if( have_rows('bonuses') ):

    $count = 1;
    // Loop through rows.

      while( have_rows('bonuses') ) : the_row();

        if ($count <= $date_today) { 
          $bid = get_sub_field('bonus'); 
          echo '<div class="mt-5 pt-1" style="border-top: 2px dotted #ccc">';
          echo '<div class="text-center mt-1">' . $christmas_emoji_col[$count] . ' <strong>December ' . $count . '</strong></div>';
          require locate_template('components/card/bonus-long.php');
          echo '</div>';
        }

      $count++; 
      // End loop.
      endwhile;


    // Do something...
    endif; 
    ?>

    </div><!-- .col --> 
  </div><!-- .row -->
</div><!-- .container -->



<?php get_footer();