<?php
$steps_heading  = get_field('steps_heading');
$steps_repeater = get_field('steps_repeater') ?: [];

get_template_part('template-parts/content/content', 'steps', array(
  'steps_heading'  => $steps_heading,
  'steps_repeater' => $steps_repeater,
));
