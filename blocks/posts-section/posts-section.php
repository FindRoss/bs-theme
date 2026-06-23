<?php
$heading      = get_field('post_section_heading');
$kicker       = get_field('post_section_kicker') ?: '';
$term_raw = get_field('post_section_category');
if (is_array($term_raw)) $term_raw = reset($term_raw);
$term_obj = is_object($term_raw) ? $term_raw : (is_numeric($term_raw) ? get_term($term_raw) : null);
$manual_posts = get_field('post_section_posts') ?: [];
$count        = intval(get_field('post_section_count') ?: 4);

if (!empty($manual_posts)) {
  $posts = $manual_posts;
} elseif ($term_obj) {
  $featured_ids = get_field('featured_posts', $term_obj) ?: [];
  if (!empty($featured_ids)) {
    $q = new WP_Query([
      'post_type'      => 'post',
      'posts_per_page' => $count,
      'post__in'       => $featured_ids,
      'orderby'        => 'post__in',
    ]);
  } else {
    $q = new WP_Query([
      'post_type'      => 'post',
      'posts_per_page' => $count,
      'cat'            => $term_obj->term_id,
    ]);
  }
  $posts = $q->posts;
  wp_reset_postdata();
} else {
  $posts = [];
}

if (empty($posts)) return;

$heading = $heading ?: ($term_obj ? $term_obj->name : '');
$link    = $term_obj ? get_term_link($term_obj) : '';

get_template_part('template-parts/section/posts-section', null, compact('heading', 'kicker', 'link', 'posts', 'count'));
