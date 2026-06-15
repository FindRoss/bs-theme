<?php
$fields = bc_get_topic_section_fields('get_field');

$ts_args = bc_topic_section_args_from_term_fields(
  $fields['heading'],
  $fields['kicker'],
  $fields['taxonomy'],
  $fields['term']
);

if (current_user_can('manage_options')) {
  echo '<!-- topic-section debug: ' . esc_html(print_r(['fields' => $fields, 'ts_args' => $ts_args], true)) . ' -->';
}

if ($ts_args) {
  get_template_part('template-parts/section/topic-section', null, $ts_args);
}
