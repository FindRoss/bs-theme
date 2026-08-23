<?php
$heading = $args['heading'] ?? '';
$kicker  = $args['kicker'] ?? '';
$link    = $args['link'] ?? null;
$count   = intval($args['count'] ?? 3);
$rows    = array_slice($args['rows'] ?? [], 0, $count);

// Normalise link: accept plain string or array with url/title/target
if (is_string($link) && $link) {
  $link = ['url' => $link, 'title' => 'View all', 'target' => ''];
}

$aff_link_map = [];
foreach ($rows as $row) {
  if (!empty($row['review'])) {
    $aff_link_map[$row['review']] = $row['affiliate_link'] ?? '';
  }
}
$post_ids = array_column($rows, 'review');

if (empty($post_ids)) return;
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
    <?php if (!empty($link['url'])) : ?>
      <a class="sec-head__link" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
        <span>View all</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
      </a>
    <?php endif; ?>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
    <?php
    $reviews_query = new WP_Query([
      'post_type'      => 'review',
      'post__in'       => $post_ids,
      'orderby'        => 'post__in',
      'posts_per_page' => $count,
    ]);
    while ($reviews_query->have_posts()) :
      $reviews_query->the_post();
      get_template_part('template-parts/card/review-card', null, [
        'aff_link' => $aff_link_map[get_the_ID()] ?? '',
      ]);
    endwhile;
    wp_reset_postdata();
    ?>
  </div>

</section>
