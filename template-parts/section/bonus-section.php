<?php
$term    = $args['term'];
$heading = $args['heading'] ?? '';
$kicker  = $args['kicker'] ?? '';
$link    = $args['link'] ?? '';

$featured_ids = get_field('featured_bonuses', $term);
$featured_ids = is_array($featured_ids) ? array_slice($featured_ids, 0, 3) : [];

if (!empty($featured_ids)) {
  $query = new WP_Query([
    'post_type'      => 'bonus',
    'posts_per_page' => 3,
    'post__in'       => $featured_ids,
    'orderby'        => 'post__in',
  ]);
} else {
  $query = new WP_Query([
    'post_type'      => 'bonus',
    'posts_per_page' => 3,
    'tax_query'      => [[
      'taxonomy' => 'bonus_type',
      'field'    => 'term_id',
      'terms'    => $term->term_id,
    ]],
  ]);
}

if (!$query->have_posts()) { wp_reset_postdata(); return; }
?>
<section class="bonus-section">

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

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <?php get_template_part('template-parts/card/card', 'shanghai'); ?>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>

</section>
