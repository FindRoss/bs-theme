<?php 
// Custom search fetch endpoint 
function search_two_endpoint() {
  register_rest_route('chaser/v2', 'search', array(
      'methods'  => 'GET',
      'callback' => 'search_two_callback',
  ));
}

add_action('rest_api_init', 'search_two_endpoint');
// Search callback
function search_two_callback($data) {
  $results = array();
  $terms = array();

  $search_term = sanitize_text_field($data['term']);
  $post_type   = $data['type'];
  $order       = $data['order'];
  $orderby     = $data['orderby'];
  
  if ($post_type == 'all') {
    $post_type = ['post', 'page', 'review', 'bonus', 'streamer', 'slot', 'glossary'];
  } else {
    $post_type = json_decode($post_type, true);
  }
  
  $page = !empty($data['page']) ? absint($data['page']) : 1;
  $args = array(
    's'              => $search_term,
    'post_type'      => $post_type,
    'posts_per_page' => 20,
    'paged'          => $page,
    'order'          => $order, 
    'orderby'        => $orderby
  );

  $query = new WP_Query($args);

  $taxonomy_search_args = array(
    'taxonomy'   => array('cryptocurrency', 'game', 'provider', 'payment', 'bonus_type'), 
    'search'     => $search_term,      
    'number'     => 6,                
    'orderby'    => 'name',            
    'order'      => 'ASC',             
  );
  $get_terms = get_terms($taxonomy_search_args);
  
  foreach($get_terms as $term) :

    $image_from_term = get_field('icon', $term); 

     $terms[] = array(
      'title' => $term->name,
      'link'  => get_term_link($term->term_id, $term->taxonomy),
      'image' => $image_from_term['sizes']['thumbnail']
     );
  endforeach;


  // Check if there are posts
  if ($query->have_posts()) {
    
    while ($query->have_posts()) {
      $query->the_post();
       
        $results[] = array(
          'title'    => get_the_title(),
          'link'     => get_the_permalink(),
          'postType' => get_post_type(),
          'image'    => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
          'excerpt'  => get_the_excerpt()
        );
    }
    wp_reset_postdata();
  } 

  // Include pagination info
  return array(
    'terms'   => $terms,
    'results' => $results,
    'currentPage' => $page,
    'totalPages' => $query->max_num_pages, // Total number of pages.
    'totalPosts' => $query->found_posts,   // Total number of posts.
  );
};