<?php
get_template_part('template-parts/review/review-bonus', null, [
  'review_ids'        => get_field('review_bonus') ?: [],
  'review_bonus_type' => get_field('review_bonus_type') ?? 0,
]);
