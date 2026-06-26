<?php
$list_repeater = get_field('bc_list') ?: [];
$list_type     = get_field('bc_list_type') ?: 'arrow';

get_template_part('template-parts/content/content', 'list', array(
  'list_repeater' => $list_repeater,
  'list_type'     => $list_type,
));
