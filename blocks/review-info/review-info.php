<?php
get_template_part('template-parts/review/review-info', null, [
  'review_id'        => get_field('review_info'),
  'review_info_type' => get_field('review_info_type') ?? 0,
]);
