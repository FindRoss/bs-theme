<?php 

/** Change the Lang attribute on the HTML element based on the post type **/
function __language_attributes($lang){
  // Set Default Language
  $post_lang = 'en-US';
  // Get the post type 
  $post_type = get_post_type(get_the_ID());
  // Update Language If Spanish or Portuguese
  if ($post_type === "spanish") {
    $post_lang = 'es';
  };

  // return the new attribute
  return 'lang="'. $post_lang .'"';
}
add_filter('language_attributes', '__language_attributes');