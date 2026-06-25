<?php
$list_heading  = get_field('bc_list_heading');
$list_repeater = get_field('bc_list') ?: [];
$list_type     = get_field('bc_list_type') ?: 'arrow';

// print_r($list_heading);
// print_r($list_type);
// print_r($list_repeater);

get_template_part('template-parts/content/content', 'list', array(
  'list_heading'  => $list_heading,
  'list_repeater' => $list_repeater,
  'list_type'     => $list_type,
));
