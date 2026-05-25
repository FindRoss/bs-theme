<?php 
 $id = get_the_ID(); 
 $details_group = get_field('details_group', $id);
 $name          = $details_group['name']; 
 $aff_link      = $details_group['affiliate_link']; 
 $bonus_group   = get_field('bonus_group', $id);
 $media_group   = get_field('media_group', $id);
 $themeColor    = $media_group['theme_color'];
 $review_link   = get_the_permalink($id);
 $bonus_text    = $bonus_group['bonus'];
?>

<div class="card card-absolute review-pill">
  <a class="card-absolute__link" href="<?php echo esc_url($review_link); ?>" aria-label="Read <?php echo esc_attr($name); ?> review"></a>
  <div class="review-pill__body">
    <img class="logo" src="<?php echo get_the_post_thumbnail_url($id, 'site-small-logo'); ?>" alt="<?php echo $name . ' logo'; ?>" width="100" height="50" title="<?php echo $name; ?>"/>
    <?php if ($bonus_text) : ?>
      <div class="card-kunming__bonus-pill">
        <span class="card-kunming__bonus-icon"><i data-feather="gift"></i></span>
        <div><span><?php echo esc_html($bonus_text); ?></span></div>
      </div>
    <?php endif; ?>
  </div>
  <div class="card-absolute__ctas review-pill__cta">
    <a class="button button__primary" href="<?php echo esc_url($aff_link); ?>" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">
       <i data-feather="external-link"></i>
    </a>
  </div>
</div>