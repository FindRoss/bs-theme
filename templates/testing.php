<?php 
/* 
Template Name: Testing
Template Post Type: page
*/ 
?>

<?php get_header(); ?>

<div class="container py-5">
  <h1>Testing</h1>

  <!-- $published_reviews = new WP_Query(array(
        'post_type'      => 'review', 
        'posts_per_page' => -1,  // Still retrieving all posts
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
        'fields'         => 'ids',  // Retrieve only the post IDs
        'meta_query'     => array(
            array(
              'key'     => 'details_group_closed',
              'value'   => '1', 
              'compare' => '!='
            ),
          )
        )); -->


  <h2 class="mt-5">Note Blocks</h2>

 
  <?php
  $all_posts = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields'         => 'ids',  // Retrieve only the post IDs
  ));

  if ($all_posts->have_posts()) :
    $post_number = 1;
    foreach ($all_posts->posts as $post_id) :
      $post = get_post($post_id);
      $blocks = parse_blocks($post->post_content);
      foreach ($blocks as $block) {
        if ($block['blockName'] === 'acf/note') {
          echo '<div class="note-block">';
          echo '<span>' . $post_number . '. </span>';
          echo '<a href="' . get_permalink($post_id) . '" target="_blank">' . get_the_title($post_id) . '</a>';
          echo '</div>';
          $post_number++;
        }
      }
    endforeach;
  endif;
  ?>
  

</div><!-- .container --> 

<?php get_footer(); ?>