<?php
$top_sites = get_field('sites', 'options'); 
$top_bonuses = get_field('top_bonus', 'options');


echo '<aside class="sidebar mt-4">';

// if it isnt the homepage, show the ads
if(!is_front_page()) {
  echo '<section class="sidebar__widget">';
  require locate_template('components/ads/sidebar.php');
  echo '</section>';
};


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
      require locate_template('components/card/review-pill.php');
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
      require locate_template('components/card/bonus-pill.php');
    endwhile;
    wp_reset_postdata();
    echo '</section>';
  endif;
}


echo '</aside>';
