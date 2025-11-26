<?php
$id = get_field('review'); 
if (!$id) return '';

$details_group = $id ? get_field('details_group', $id) : null;
if (!$details_group) return '';
$closed    = $details_group['closed'];
if ($closed) return '';
$goto_link = $details_group['affiliate_link'];
$name      = $details_group['name'];
// $bonus  = $details_group['bonus']; 

$media_group   = $id ? get_field('media_group', $id) : null;
if (!$media_group) return '';
$featured_img  = get_the_post_thumbnail_url($id, 'small-site-logo');

if ($goto_link !== null): ?>
  <div class="review-cta">
    <a rel="nofollow" href="<?php echo esc_url($goto_link); ?>" target="_blank">
      <img src="<?php echo $featured_img; ?>" width="220" height="110" /> 
    </a>
    <div class="review-cta__ctas">
      <a class="button button__outline" href="<?php echo get_the_permalink($id); ?>"><?php echo $name; ?> review</a>
      <a class="button button__primary" rel="nofollow" href="<?php echo esc_url($goto_link); ?>" target="_blank">Goto <?php echo $name; ?></a>
    </div>
  </div>
<?php endif; ?>