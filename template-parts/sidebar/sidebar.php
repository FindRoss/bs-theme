<?php
$top_sites = get_field('sites', 'options'); 
$top_bonuses = get_field('top_bonus', 'options');

if (!is_front_page()) { 
  if (function_exists('geot_target') && geot_target( 'US' )) { 
    if (is_active_sidebar( 'us-sidebar-ad' )) { 
      echo '<section class="sidebar__widget advert">';
        dynamic_sidebar('us-sidebar-ad');
      echo '</section>';
    }
  } else {
    if (is_active_sidebar( 'sidebar-ad' )) { 
      echo '<section class="sidebar__widget advert">';
        dynamic_sidebar('sidebar-ad');
      echo '</section>';
    }
  }
}

if(!empty($top_sites)) { 

  $sites_query = new WP_Query(array(
    'post_type'      => 'review',
    'orderby'        => 'post__in',
    'post__in'       => $top_sites,
    'posts_per_page' => 5
  )); 

  if ($sites_query->have_posts()) :
    echo '<section class="sidebar__widget">';

    echo '<h2 class="sidebar__widget--title">Top Sites</h2>';

    while ($sites_query->have_posts()) : $sites_query->the_post(); 
      get_template_part('template-parts/card/review-pill');
    endwhile;

    echo '</section>';
    wp_reset_postdata();
  endif;

}

if(!empty($top_bonuses)) { 

  $bonus_query = new WP_Query(array(
    'post_type'      => 'bonus',
    'orderby'        => 'post__in',
    'post__in'       => $top_bonuses,
    'posts_per_page' => is_front_page() ? 2 : 5,
    'meta_query'     => bonus_expired_meta_query()
    )
  );
  
  if ($bonus_query->have_posts()) :
    echo '<section class="sidebar__widget">';
      $top_bonus_title = count($top_bonuses) > 1 ? 'Top Bonuses' : 'Top Bonus';
      echo '<h2 class="sidebar__widget--title">' . $top_bonus_title . '</h2>';

      while ($bonus_query->have_posts()) : $bonus_query->the_post(); 
        get_template_part('template-parts/card/bonus-pill');
      endwhile;
    wp_reset_postdata();
    echo '</section>';
  endif;
}
