<div class="review-bonus-block">
  <div class="review-bonus-block__layout">

<?php 

$review_bonus = get_field('review_bonus') ?: [];

foreach ($review_bonus as $review_id) {

  $link = get_field('details_group', $review_id)['affiliate_link'] ?? null;
  $link_output = '<a target="_blank" href="' . $link . '" class="button button__primary"><span class="text">Visit</span><i data-feather="arrow-right-circle"></i></a>';

  $logo = get_the_post_thumbnail_url($review_id, 'site-small-logo'); 
  $transparent_logo =  get_field('media_group', $review_id)['transparent_logo'] ?? null;
  
  $link = get_the_permalink($review_id);
  $title = get_the_title($review_id);
  $img_output = '<a class="img-link" href="' . $link . '"><img width="100" height="auto" class="logo" src="' . $transparent_logo . '" alt="' . $title . '" title="' . $title . '"></a>';

  
  $bonus_title = get_field('bonus_group', $review_id)['bonus_title'] ?? null;
  $bonus = get_field('bonus_group', $review_id)['bonus'] ?? null;
  $bonus_plus = get_field('bonus_group', $review_id)['bonus_plus'] ?? null;
  $bonus_terms = get_field('bonus_group', $review_id)['bonus_terms'] ?? null;

  
  
  if (!$bonus) return null;

  $html  = '<div class="bonus-div">';
  if ($bonus_title) {
    $html .= '<div class="title">' . esc_html($bonus_title) . '</div>';
  }
  $html .= '<div class="bonus">' . esc_html($bonus) . '</div>';
  if ($bonus_plus) {
    $html .= '<div class="plus">' . esc_html($bonus_plus) . '</div>';
  }
  $html .= '</div>';

  ?>
  
  <div class="review-bonus">
    <div class="review-bonus__image">
      <?php echo $img_output; ?>
    </div>
    <div class="review-bonus__offer">
      <?php echo $html; ?>
    </div>
    <div class="review-bonus__cta">
      <?php echo $link_output; ?>
    </div>
  </div>
  <?php if ($bonus_terms) { ?>
    <div class="review-bonus__terms">
      <?php echo esc_html($bonus_terms); ?>
    </div>
  <?php } ?>


<?php } ?>



   
  </div>
</div>

      