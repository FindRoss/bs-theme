<?php
  $review_id = get_field('review_info'); 
  $review_info_type = get_field('review_info_type');
  
  

  $title = get_the_title($review_id);
  
  $founded = get_field('details_group', $review_id)['year_founded'] ?? null;
  
  $crypto_terms = get_the_terms($review_id, 'cryptocurrency');
  $crypto_output = display_review_crypto($crypto_terms, 3); 



  $vip_group = get_field('vip_group', $review_id);
  $has_vip = is_array($vip_group) && !empty($vip_group['has_vip_program']);
  $vip_output = $has_vip ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';

  $variable_output = ''; 

  if ($review_info_type == 1) {
    $has_live_betting = get_field('betting_group', $review_id)['live_betting'] ?? null;
    $live_betting_icon = $has_live_betting ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';
    $variable_output = '<li><span>Live Betting</span><span>' . $live_betting_icon . '</span></li>'; 
  } else {
    $num_games = get_field('games_group', $review_id)['num_games'] ?? null;
    $variable_output = '<li><span>Games</span><span>' . $num_games . '</span></li>'; 
  }

  $homepage_img = get_field('media_group', $review_id)['homepage'] ?? null;
?>

<div class="review-info-block">
  <div class="review-info-block__layout">
    <div class="screenshot">
      <?php
        if ($homepage_img) {
          $img_url = $homepage_img['sizes']['medium_large'] ?? $homepage_img['url']; ?>
          <img src="<?php echo esc_url($img_url)?>" alt="<?php echo esc_attr(get_the_title($review_id)); ?>">
        <?php } 
      ?>
    </div>
    <div class="info">
      <ul>
        <li>
          <span>Year Founded</span>
          <span><?php echo $founded; ?></span>
        </li>
        <li>
          <span>Crypto</span>
          <span><div class="crypto-icons"><?php echo $crypto_output; ?></div></span>
        </li>
        <?php echo $variable_output; ?>
        <li>
          <span>VIP Program</span>
          <span><?php echo $vip_output; ?></span>
        </li>
      </ul>
    </div>
  </div>
</div>