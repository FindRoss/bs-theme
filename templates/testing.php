<?php 
/* 
Template Name: Testing
Template Post Type: page
*/ 
?>

<?php get_header(); ?>

<div class="container py-5">
  <h1>Testing</h1>

  <h2 class="mt-5">All Published Reviews</h2>

<?php 
  $published_reviews = new WP_Query(array(
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
      ));

  if ($published_reviews->have_posts()) : 
    echo '<table>'; // Start the table
    foreach ($published_reviews->posts as $post_id) : // Loop through the IDs

      // Get the post object based on ID
      $post = get_post($post_id);

      echo '<tr>'; // Start a new row for each post
      echo '<td>' . $post->post_title . '</td>';  // Get title in the second column
      echo '<td><a href="' . get_permalink($post_id) . '">' . get_permalink($post_id) . '</a></td>';  // Get permalink in the third column
      echo '</tr>'; // End the row

    endforeach; 
    echo '</table>'; // End the table
    wp_reset_postdata(); // Reset post data after custom query
  endif;
?>


  
  <?php 
    // if (function_exists('geot_user_country')) {
    //   $country = geot_user_country();
    //     var_dump($country); // Debugging output
    // } else {
    //     echo 'The function geot_user_country does not exist.';
    // }
  ?> 

  <!-- <h2 class="mt-5">Note Blocks</h2> -->

  <?php
  // $all_posts = new WP_Query(array(
  //   'post_type'      => 'post',
  //   'posts_per_page' => -1,
  //   'post_status'    => 'publish'
  // ));

  // if ($all_posts->have_posts()) :
  //   $post_number = 1;
  //   while ($all_posts->have_posts()) : $all_posts->the_post();
  //     $blocks = parse_blocks(get_the_content());
  //     foreach ($blocks as $block) {
  //       if ($block['blockName'] === 'acf/note') {
  //         echo '<div class="note-block">';
  //         echo '<span>' . $post_number . '. </span>';
  //         echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
  //         echo '</div>';
  //         $post_number++;
  //       }
  //     }
  //   endwhile;
  //   wp_reset_postdata();
  // endif;
  ?>


  

</div><!-- .container --> 

<?php get_footer(); ?>