<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php $featured_img = get_the_post_thumbnail_url(); ?>
<?php $current_post_id = get_the_ID(); ?>

<style>
  .cat-pill {
    padding: 0.3rem 0.75rem;
    background: var(--color-bg-400);
  }
</style>

<?php 
// author
$author_id = get_the_author_meta('ID'); 
$get_avatar_url = get_avatar_url($author_id);

$slot_intro      = get_field('slot_intro'); 
$slot_reels      = get_field('slot_reels');
$slot_paylines   = get_field('slot_paylines');
$slot_rtp        = get_field('slot_rtp');
$slot_scatter    = get_field('slot_scatter');
$slot_free_spins = get_field('slot_free_spins');
$slot_wild       = get_field('slot_wild');

function formatBool ($term) {
  $term = $term = 1 ? 'Yes' : 'No';
  return $term;
}

$slot_info = array(
  'Reels'      => $slot_reels, 
  'Paylines'   => $slot_paylines,
  'RTP'        => $slot_rtp,
  'Scatter'    => formatBool($slot_scatter),
  'Free Spins' => formatBool($slot_free_spins), 
  'Wild'       => formatBool($slot_wild)
);

$slot_play_at = get_field('slot_play_at');
$play_at_args = array(
  'post_type'    => array('review'), 
  'post__in'     =>  empty($slot_play_at) ? array(-1) : $slot_play_at,
);
$play_at_query = new WP_Query( $play_at_args ); 
?>

<div class="container"> 
  <div class="row justify-content-center">
    
    <div class="col-12 col-lg-8">

      <article class="mb-5 pb-4">

        <!-- heading --> 
        <div class="mb-4 pb-4 border-bottom">
              
          <!-- image --> 
          <img class="w-100 h-auto mb-4 rounded-corners border" width="600" height="311" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />

          <!-- title --> 
          <h1 class="mb-4"><?php the_title(); ?></h1>

          <!-- meta --> 
          <div class="main--meta d-flex flex-row align-items-center">
            <img src="<?php echo $get_avatar_url; ?>" width="55" height="55" class="p-1 rounded-circle shadow-sm border"/> 
            <!-- TEXT -->    
            <div class="d-flex flex-column ms-2">
              <div class="">
                <span>By <?php the_author(); ?></span>
              </div>
              <div class="fs-small font-bold text-muted">
                <span>Published <?php the_date('M jS, Y'); ?></span>
              </div>
            </div>
          <!-- !Text --> 
          </div>

        </div>

        <!-- intro --> 
        <div class="main--content">
          <?php echo $slot_intro; ?>
        </div>

        <!-- table --> 
        <?php if ($slot_reels || $slot_paylines || $slot_rtp || $slot_scatter || $slot_free_spins || $slot_wild) : ?>
          <div class="my-4 main--content">
            <table class="table">
              <tbody>
                <?php foreach($slot_info as $key => $value) { ?>
                  <?php if ($value !== '') : ?>
                    <tr class="table-success">
                      <td style="width: 50%;"><?php echo $key; ?></td>
                      <td class="fw-bold"><?php echo $value; ?></td>
                    </tr>
                  <?php endif; ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
        <!-- content --> 
        <div class="pb-2 main--content">
          <?php the_content(); ?>
        </div>
        
        <!-- play at --> 
        <?php if ( $play_at_query->have_posts() ) : ?>
        <div>
          <div class="main--content">
            <h2 class="">Where to Play <?php the_title(); ?></h2>
          </div>
          <div class="row">
            <?php while ( $play_at_query->have_posts() ) : $play_at_query->the_post(); ?> 
              <div class="col-12 col-sm-6 mt-3">
                <?php require locate_template('components/card/review-excerpt.php'); ?>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
        <?php endif; ?> 
        <?php wp_reset_postdata(); ?>
      </article>

    </div><!-- .col -->  
  </div><!-- .row --> 
</div><!-- .container --> 

<?php 
$args = array(
  'post_type' => 'slots', 
  'post__not_in' => array($current_post_id),
  'posts_per_page' => 3
); ?>

<?php $latest_query = new WP_Query( $args ); ?>

<?php if ( $latest_query->have_posts() ) : ?>
<div class="container">
    <!-- section title! --> 
    <div class="section-title__wrapper">
    <?php chaser_styled_sub_heading(array(
      'heading' => 'More Slots'
    )); ?>
  </div>
  <nav>
    <div class="row">
      <?php while ( $latest_query->have_posts() ) : $latest_query->the_post();  
        require locate_template( 'components/card/slot.php' ); 
      endwhile; ?>
    </div>
  </nav>
</div><!-- .container --> 
<?php endif; ?>


<!-- featured posts -->
<?php featured_articles(); ?>


<?php endwhile; else: ?>
  <div class="container mb-5">
    <div class="alert alert-primary p-5" role="alert">
    There is no post to show.
    </div>
  </div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>