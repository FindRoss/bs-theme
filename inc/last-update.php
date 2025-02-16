<?php

function wpb_last_updated_date( $content ) {
  $u_time          = get_the_time('U'); 
  $u_modified_time = get_the_modified_time('U'); 
  
  if ($u_modified_time >= $u_time + 86400) { 
      $updated_date = get_the_modified_time('F jS, Y');
      $updated_time = get_the_modified_time('h:i a'); 
      return $updated_date;
  } 
};