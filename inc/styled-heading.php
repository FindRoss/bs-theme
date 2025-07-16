<?php

function chaser_styled_sub_heading($args) {
  $heading = esc_html($args['heading'] ?? '');
  $link = esc_url($args['link'] ?? '');

  if (!$heading) return;

  ob_start(); ?>

  <h2 class="section-heading__title h4">
    <?php 
      if ($link) { echo '<a href="' . $link . '">'; } 
        echo $heading; 
      if ($link) { echo get_svg_icon('chevron-right') . '</a>'; } 
    ?>
  </h2>
  
  <?php $output = ob_get_clean(); 
  
  echo '<div class="section-heading d-flex align-items-center">' . $output . '</div>';
}