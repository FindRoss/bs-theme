<?php
$term  = $args['term'] ?? null;
$count = intval($args['count'] ?? 6);

if (!$term) return;

$featured_bonuses = get_field('featured_bonuses', $term);
$featured_bonuses = is_array($featured_bonuses) ? $featured_bonuses : [];

$additional_bonuses = get_posts([
  'post_type'      => 'bonus',
  'posts_per_page' => -1,
  'fields'         => 'ids',
  'tax_query'      => [[
    'taxonomy' => $term->taxonomy,
    'field'    => 'term_id',
    'terms'    => $term->term_id,
  ]],
  'post__not_in'   => $featured_bonuses,
]);
$additional_bonuses = is_array($additional_bonuses) ? $additional_bonuses : [];

$bonus_ids = array_slice(array_merge($featured_bonuses, $additional_bonuses), 0, $count);

$query = !empty($bonus_ids) ? new WP_Query([
  'post_type'      => 'bonus',
  'posts_per_page' => $count,
  'post__in'       => $bonus_ids,
  'orderby'        => 'post__in',
]) : null;
?>
<?php if ($query && $query->have_posts()) : ?>
  <div class="bonus-list flex flex-col gap-3">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <?php get_template_part('template-parts/card/card', 'suzhou'); ?>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
<?php else : ?>
  <div class="alert alert-info mt-3 mb-3 p-4 border rounded" style="border-color: var(--color-info-300); background-color: var(--color-info-50, #f0f7ff);">
    <p class="m-0">No bonuses available currently.</p>
  </div>
<?php endif; ?>
