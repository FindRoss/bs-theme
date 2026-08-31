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

if (empty($bonus_ids)) return;

$query = new WP_Query([
  'post_type'      => 'bonus',
  'posts_per_page' => $count,
  'post__in'       => $bonus_ids,
  'orderby'        => 'post__in',
]);

if (!$query->have_posts()) { wp_reset_postdata(); return; }
?>
<div class="bonus-list flex flex-col gap-3">
  <?php while ($query->have_posts()) : $query->the_post(); ?>
    <?php get_template_part('template-parts/card/card', 'suzhou'); ?>
  <?php endwhile; wp_reset_postdata(); ?>
</div>
