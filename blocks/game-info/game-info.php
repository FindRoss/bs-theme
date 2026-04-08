<?php

// Block fields
$heading      = get_field('game_info_heading');
$image        = get_field('game_info_image');
$content      = get_field('game_info_content');
$is_landscape = $image && ( $image['width'] > $image['height'] );
$site_id      = get_field('game_info_site');

if ($site_id) {
  $details_group = $site_id ? get_field('details_group', $site_id) : null;
  $closed    = $details_group['closed'];
  $goto_link = $details_group['affiliate_link'];
  $name      = $details_group['name'];
  $bonus     = $details_group['bonus']; 
}

?>

<div class="game-info">

  <?php if ( $heading ) : ?>
    <h2 class="game-info__heading"><?php echo esc_html($heading); ?></h2>
  <?php endif; ?>

  <div class="game-info__top<?php echo $is_landscape ? ' game-info__top--landscape' : ''; ?>">

    <?php if ( $image ) : ?>
      <div class="game-info__image">
        <img
          src="<?php echo esc_url($image['url']); ?>"
          alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>"
          width="<?php echo esc_attr($image['width']); ?>"
          height="<?php echo esc_attr($image['height']); ?>"
        >
      </div>
    <?php endif; ?>

    <?php if ( have_rows('game_info_repeater') ) : ?>
      <dl class="game-info__stats">
        <?php while ( have_rows('game_info_repeater') ) : the_row(); ?>
          <?php
            $label = get_sub_field('label');
            $value = get_sub_field('value');
            if ( ! $label && ! $value ) continue;
          ?>
          <div class="game-info__stat">
            <dt class="game-info__stat-label"><?php echo esc_html($label); ?></dt>
            <dd class="game-info__stat-value"><?php echo esc_html($value); ?></dd>
          </div>
        <?php endwhile; ?>
      </dl>
    <?php endif; ?>

  </div>

  <?php if ( $content ) : ?>
    <div class="game-info__content">
      <?php echo wp_kses_post($content); ?>
    </div>
  <?php endif; ?>

  <?php if ( $site_id && ! $closed && $goto_link ) : ?>
    <a class="button button__primary" rel="sponsored noopener" href="<?php echo esc_url($goto_link); ?>" target="_blank">Play on <?php echo esc_html($name); ?></a>
  <?php endif; ?>

</div>
