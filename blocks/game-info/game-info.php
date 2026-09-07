<?php
get_template_part('template-parts/game-info/game-info', null, [
  'heading'       => get_field('game_info_heading'),
  'heading_level' => get_field('game_info_heading_level') ?: 'h2',
  'image'         => get_field('game_info_image'),
  'content'       => get_field('game_info_content'),
  'repeater'      => get_field('game_info_repeater') ?: [],
  'site_ids'      => get_field('game_info_site') ?: [],
]);
