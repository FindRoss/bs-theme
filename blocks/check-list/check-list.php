<?php
$check_list_heading  = get_field('check_list_heading');
$check_list_repeater = get_field('check_list_repeater') ?: [];
$check_list_layout   = get_field('check_list_layout') ?: 'row';

get_template_part('template-parts/content/content', 'check-list', array(
  'check_list_heading'  => $check_list_heading,
  'check_list_repeater' => $check_list_repeater,
  'check_list_layout'   => $check_list_layout,
));
