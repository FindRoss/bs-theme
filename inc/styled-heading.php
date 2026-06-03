<?php

function chaser_styled_sub_heading($args) {
  $heading = esc_html($args['heading'] ?? '');
  $link    = esc_url($args['link'] ?? '');

  if (!$heading) return;

  $link_html = '';
  if ($link) {
    $arrow = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>';
    $link_html = '<a class="sec-head__link" href="' . $link . '"><span>View all</span>' . $arrow . '</a>';
  }

  echo '<div class="sec-head">'
    . '<div class="sec-head__l">'
    . '<span class="sec-head__bar"></span>'
    . '<div class="sec-head__titles"><h2 class="sec-head__title">' . $heading . '</h2></div>'
    . '</div>'
    . $link_html
    . '</div>';
}