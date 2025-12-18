<?php 
/* 
Template Name: Testing
Template Post Type: page
*/ 
?>

<?php get_header(); ?>

<div class="container py-5">
  <?php 
    global $wpdb;

    $field_name = 'faqs';

    // Get posts where the field exists AND has a non-empty value
    // $posts = $wpdb->get_results( $wpdb->prepare(
    //     "SELECT p.ID, p.post_title
    //      FROM {$wpdb->postmeta} pm
    //      INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
    //      WHERE pm.meta_key = %s
    //        AND pm.meta_value != ''
    //        AND p.post_type = 'post'
    //        AND p.post_status = 'publish'
    //      ORDER BY p.post_date DESC",
    //     $field_name
    // ) );


    $posts = $wpdb->get_results( $wpdb->prepare(
        "SELECT p.ID, p.post_title
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE pm.meta_key = %s
          AND pm.meta_value > 0
          AND p.post_type = 'post'
          AND p.post_status = 'publish'
        ORDER BY p.post_date DESC",
        $field_name
    ) );


    if ( $posts ) {
        echo '<ul>';
        foreach ( $posts as $post ) {
            $url = get_permalink( $post->ID );
            echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $post->post_title ) . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo "No posts have a value for this field yet.";
    }
  ?>
  
</div><!-- .container --> 

<?php get_footer(); ?>