<?php
$top_bonuses = get_field('bonuses', 'options');
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

$geo_top     = bs_get_geo_top_sites();
$sidebar_ids = $geo_top['post_ids'];

if ( ! empty( $sidebar_ids ) ) {

  $sites_query = new WP_Query( array(
    'post_type'      => 'review',
    'orderby'        => 'post__in',
    'post__in'       => $sidebar_ids,
    'posts_per_page' => count( $sidebar_ids ),
  ) );

  if ( $sites_query->have_posts() ) :
    echo '<section class="sidebar__widget pills-grid__section">';
    echo '<header class="pills-grid__header">';
    echo '<h2 class="pills-grid__title">' . esc_html( $geo_top['title'] ) . '</h2>';
    if ( ! empty( $geo_top['link'] ) ) {
      echo '<a class="pills-grid__link" href="' . esc_url( $geo_top['link'] ) . '">View all <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="13 6 19 12 13 18"></polyline></svg></a>';
    }
    echo '</header>';
    echo '<div class="pills-grid__pills">';

    $rank = 0;
    while ( $sites_query->have_posts() ) : $sites_query->the_post();
      $rank++;
      get_template_part( 'template-parts/card/review-pill', null, [
        'rank'   => $rank,
        'is_top' => ( $rank === 1 ),
      ] );
    endwhile;

    echo '</div></section>';
    wp_reset_postdata();
  endif;

}

if(!empty($top_bonuses)) { 

  $bonus_query = new WP_Query(array(
    'post_type'      => 'bonus',
    'orderby'        => 'post__in',
    'post__in'       => $top_bonuses,
    'posts_per_page' => 5,
    )
  );
  
  if ($bonus_query->have_posts()) :
    $top_bonus_title = count($top_bonuses) > 1 ? 'Top Bonuses' : 'Top Bonus';
    echo '<section class="sidebar__widget pills-grid__section">';
      echo '<header class="pills-grid__header">';
        echo '<h2 class="pills-grid__title">' . esc_html($top_bonus_title) . '</h2>';
        echo '<a class="pills-grid__link" href="/bonuses/">View all <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="13 6 19 12 13 18"></polyline></svg></a>';
      echo '</header>';
      echo '<div class="pills-grid__pills">';

      $rank = 0;
      while ($bonus_query->have_posts()) : $bonus_query->the_post();
        $rank++;
        get_template_part('template-parts/card/bonus-pill', null, [
          'is_top' => ($rank === 1),
        ]);
      endwhile;

      echo '</div>';
    wp_reset_postdata();
    echo '</section>';
  endif;
}
