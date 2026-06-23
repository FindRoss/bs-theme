<?php
$term_obj = get_field('bonus_section_type');
if (!$term_obj) return;

$heading = get_field('bonus_section_heading') ?: $term_obj->name . ' Bonuses';
$kicker  = get_field('bonus_section_kicker') ?: '';
$link    = get_term_link($term_obj);

get_template_part('template-parts/section/bonus-section', null, [
  'term'    => $term_obj,
  'heading' => $heading,
  'kicker'  => $kicker,
  'link'    => $link,
]);
