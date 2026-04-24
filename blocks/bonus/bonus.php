<?php
$bid = get_field('bonus');
if (!$bid) return;

get_template_part('template-parts/card/card-suzhou', null, ['id' => $bid]);
