<?php 
 $id = get_the_ID(); 
 $details_group = get_field('details_group', $id);
 $name          = $details_group['name']; 
 $aff_link      = $details_group['affiliate_link']; 
 $bonus         = $details_group['bonus'];
 $media_group   = get_field('media_group', $id);
 $themeColor     = $media_group['theme_color'];
 $review_link   = get_the_permalink($id);
?>

<div class="card card-absolute review-pill">
  <a class="card-absolute__link" href="<?php echo $review_link; ?>"></a>
  <div class="review-pill__body">
    <img class="logo" src="<?php echo get_the_post_thumbnail_url($id, 'site-small-logo'); ?>" alt="<?php echo $name . ' logo'; ?>" width="100" height="50" title="<?php echo $name; ?>"/>
    <h3 class="h6">
      <?php echo $name; ?>
    </h3>
  </div>
  <div class="card-absolute__ctas review-pill__cta">
    <a class="button button__primary" href="<?php echo $aff_link; ?>" target="_blank" rel="nofollow" aria-label="Visit <?php echo $name; ?>">
       <?php echo get_svg_icon('external-link'); ?>
    </a>
  </div>
</div>