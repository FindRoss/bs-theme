<?php
$title       = $args['title'] ?? 'Browse All Bonus Types';
$exclude_ids = $args['exclude'] ?? [];

$bonus_types = array_filter(bs_get_bonus_types(), function ($type) use ($exclude_ids) {
  return !in_array($type['id'], $exclude_ids);
});
?>

<?php if ($bonus_types) : ?>
<section>
  <div class="sec-head">
    <div class="sec-head__l">
      <span class="sec-head__bar"></span>
      <div class="sec-head__titles">
        <h2 class="sec-head__title"><?php echo esc_html($title); ?></h2>
      </div>
    </div>
  </div>
  <div class="bonus-type-links mt-4">
    <?php foreach ($bonus_types as $type) :
      $term  = get_term($type['id'], 'bonus_type');
      $icon  = $term ? get_field('icon', $term) : null;
      $count = $term ? (int) $term->count : 0;
    ?>
      <a class="bonus-type-links__item" href="<?php echo esc_url($type['permalink']); ?>">
        <div class="bonus-type-links__top">
          <?php if ($icon && is_array($icon)) : ?>
            <div class="bonus-type-links__icon-wrap">
              <img class="bonus-type-links__icon" src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt'] ?: $type['title']); ?>" width="28" height="28">
            </div>
          <?php endif; ?>
          <svg class="bonus-type-links__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
        </div>
        <div class="bonus-type-links__body">
          <span class="bonus-type-links__label"><?php echo esc_html($type['title']); ?> Bonuses</span>
          <?php if ($count) : ?>
            <span class="bonus-type-links__count"><?php echo $count; ?> bonuses</span>
          <?php endif; ?>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
