<?php
$heading = $args['heading'] ?? '';
$kicker  = $args['kicker'] ?? '';
$link    = $args['link'] ?? '';
$posts   = $args['posts'] ?? [];
$count   = intval($args['count'] ?? 4);
$row_class = 'posts-row mt-4' . ($count < 4 ? ' posts-row--' . $count : '');

if (empty($posts)) return;
?>
<section class="hp-section">

  <div class="sec-head">
    <div class="sec-head__l">
      <span class="sec-head__bar"></span>
      <div class="sec-head__titles">
        <?php if ($kicker) : ?><span class="sec-head__kicker"><?php echo esc_html($kicker); ?></span><?php endif; ?>
        <h2 class="sec-head__title"><?php echo esc_html($heading); ?></h2>
      </div>
    </div>
    <?php if ($link) : ?>
      <a class="sec-head__link" href="<?php echo esc_url($link); ?>">
        <span>View all</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
      </a>
    <?php endif; ?>
  </div>

  <div class="<?php echo esc_attr($row_class); ?>">
    <?php foreach ($posts as $post) : setup_postdata($post); ?>
      <?php get_template_part('template-parts/card/card', 'beijing'); ?>
    <?php endforeach; wp_reset_postdata(); ?>
  </div>

</section>
