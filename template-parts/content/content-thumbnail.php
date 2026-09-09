 <?php
 $hide_image = get_field('hide_featured_image');
 $thumb_id   = get_post_thumbnail_id(get_the_ID());
 $image_alt  = get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: the_title_attribute(['echo' => false]);

 if (has_post_thumbnail() && !$hide_image) :
  echo wp_get_attachment_image( $thumb_id, 'large', false, array(
    'class'         => 'w-100 h-auto my-4 border-radius exclude-lazyload content-thumbnail-img',
    'alt'           => $image_alt,
    'title'         => get_the_title(),
    'width'         => '800',
    'height'        => '480',
    'fetchpriority' => 'high',
  ) );
endif; ?>
