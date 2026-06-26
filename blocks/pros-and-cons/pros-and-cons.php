<?php
$pac_pros = get_field('pac_pros') ?: [];
$pac_cons = get_field('pac_cons') ?: [];

get_template_part('template-parts/content/content', 'pros-and-cons', array(
  'pac_pros' => $pac_pros,
  'pac_cons' => $pac_cons,
));
