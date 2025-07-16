<?php

function featured_articles() {
  
  $featured_articles = get_field('articles', 'options');
  
  if (!$featured_articles) return; 
  
  $page_id = get_queried_object_id(); 
  $articles_minus_current_page = array_diff($featured_articles, array($page_id));

  $featured_args = array(
    'post_type'      => array('post', 'page'),
    'orderby'        => 'post__in',
    'post__in'       => $articles_minus_current_page,
    'posts_per_page' => 2, 
    
  );

  $featured_query = new WP_Query( $featured_args );  
?>

<div class="container mt-5 pt-5">
  <section>
    <?php chaser_styled_sub_heading(array(
      'heading' => 'Featured Articles'
    )); ?>
    <div class="row">

      <?php if ( $featured_query->have_posts() ) : 
        while ( $featured_query->have_posts() ) : $featured_query->the_post();
          echo '<div class="col-12 col-md-6 mt-3">'; 
             get_template_part('template-parts/card/card', 'beijing'); 
          echo '</div>';
        endwhile; 
        wp_reset_postdata(); 
      endif; ?> 

    </div>
  </section>
</div><!-- .container --> 


<?php };

