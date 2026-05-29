<?php get_header(); ?>

<?php 
  $table_fields = array();

  $realName     = get_field('real_name');
  $nationality  = get_field('nationality');
  $streamerName = get_field('streamer_name');
  $dob          = get_field('date_of_birth');
  $games        = get_field('favorite_games');
  $socialGroup  = get_field('socials');
  $sites        = get_field('sites');

  $kick      = !empty($socialGroup) ? $socialGroup['kick']      : '';
  $twitch    = !empty($socialGroup) ? $socialGroup['twitch']    : '';
  $twitter   = !empty($socialGroup) ? $socialGroup['x_twitter'] : '';
  $youtube   = !empty($socialGroup) ? $socialGroup['youtube']   : '';
  $instagram = !empty($socialGroup) ? $socialGroup['instagram'] : '';
  $discord   = !empty($socialGroup) ? $socialGroup['discord']   : '';
  $tiktok    = !empty($socialGroup) ? $socialGroup['tiktok']    : '';
  $telegram  = !empty($socialGroup) ? $socialGroup['telegram']  : '';

  // String
  if (!empty($realName)) {
    $table_fields['Real name'] = $realName;
  }
  // String
  if (!empty($streamerName)) {
    $table_fields['Streaming name'] = $streamerName;
  }
  // Date
  if (!empty($dob)) {
    $birthDate   = DateTime::createFromFormat('Ymd', $dob);
    $currentDate = new DateTime();
    $age         = $currentDate->diff($birthDate)->y;
    $table_fields['Age'] = $age;
  } else {
    $table_fields['Age'] = 'Unknown';
  }
  if (!empty($nationality)) {
    $table_fields['Nationality'] = $nationality;
  }
  // String
  if (!empty($games)) {
    $table_fields['Favorite games'] = $games;
  }
  // Socials
  function streamer_social_link($url, $platform) {
    $labels = [
      'kick'       => 'Kick',
      'twitch'     => 'Twitch',
      'twitter-x'  => 'Twitter / X',
      'youtube'    => 'YouTube',
      'instagram'  => 'Instagram',
      'discord'    => 'Discord',
      'tiktok'     => 'TikTok',
      'telegram'   => 'Telegram',
    ];
    $icon  = get_svg_icon('social-' . $platform);
    $label = $labels[$platform] ?? ucfirst($platform);
    return '<a class="social-link" href="' . esc_url($url) . '" target="_blank" rel="noopener">' . $icon . '<span>' . $label . '</span></a>';
  }
  if (!empty($kick))      $table_fields['Kick']        = streamer_social_link($kick,      'kick');
  if (!empty($twitch))    $table_fields['Twitch']      = streamer_social_link($twitch,    'twitch');
  if (!empty($twitter))   $table_fields['Twitter / X'] = streamer_social_link($twitter,   'twitter-x');
  if (!empty($youtube))   $table_fields['YouTube']     = streamer_social_link($youtube,   'youtube');
  if (!empty($instagram)) $table_fields['Instagram']   = streamer_social_link($instagram, 'instagram');
  if (!empty($discord))   $table_fields['Discord']     = streamer_social_link($discord,   'discord');
  if (!empty($tiktok))    $table_fields['TikTok']      = streamer_social_link($tiktok,    'tiktok');
  if (!empty($telegram))  $table_fields['Telegram']    = streamer_social_link($telegram,  'telegram');

  $moreStreamersQuery = new WP_Query(array(
    'post_type' => 'streamer',
    'posts_per_page' => 4,
    'post__not_in' => array(get_the_ID())
  ));
?>

<!-- get_template_parts( 'template-parts/breadcrumbs/breadcrumbs' ); -->

<div class="container">

  <article class="py-4 lg:py-6">

    <div class="streamer-header">
      <h1 class="main--title"><?php the_title(); ?></h1>
      <?php if (has_excerpt()) { ?>
        <p class="fs-large"><?php echo get_the_excerpt(); ?></p>
      <?php }; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-12">
      <div class="lg:col-span-8">

        <img
          src="<?php echo get_the_post_thumbnail_url(); ?>"
          class="w-full h-auto exclude-lazyload mb-12 rounded-2xl"
          alt="<?php the_title(); ?>"
          fetchpriority="high"
          >

        <?php if (!empty($table_fields)) { ?>
        <div>
          <h2>Details</h2>
          <table class="chaser-table">
            <tbody>
              <?php foreach($table_fields as $key => $value) { ?>
                <?php if ($value) : ?>
                  <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $value; ?></td>
                  </tr>
                  <?php endif; ?>
                <?php } ?>
            </tbody>
          </table>
        </div>
        <?php }; ?>

        <?php if (isset($sites) && is_array($sites)) : ?>
        <div class="mt-12">
          <h2>Plays at</h2>

          <?php
          global $post;
          foreach ($sites as $site) :
            $post = get_post($site);
            setup_postdata($post);
            get_template_part('template-parts/card/card', 'kunming');
          endforeach;
          wp_reset_postdata();
          ?>
        </div>
        <?php endif; ?>

        <?php
        $alt_guides = [];
        if (isset($sites) && is_array($sites)) {
          foreach ($sites as $site_id) {
            $articles = get_field('articles_group', $site_id);
            $guide_id = is_array($articles) ? ($articles['alternative_guide'] ?? null) : null;
            if ($guide_id) $alt_guides[] = $guide_id;
          }
          $alt_guides = array_unique($alt_guides);
        }
        ?>

        <?php if (!empty($alt_guides)) : ?>
        <div class="mt-8">
          <div class="review-read-more__grid">
            <?php
            global $post;
            foreach ($alt_guides as $guide_id) :
              $post = get_post($guide_id);
              setup_postdata($post);
              get_template_part('template-parts/card/card', 'guangzhou');
            endforeach;
            wp_reset_postdata();
            ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if (get_the_content()) { ?>
        <div class="main--content mt-12">
          <?php the_content(); ?>
        </div>
        <?php }; ?>
      </div>

      <aside class="sidebar lg:col-span-4">
        <?php get_template_part('template-parts/sidebar/sidebar'); ?>
      </aside>
    </div>
  </article>

  <?php if ($moreStreamersQuery->have_posts()) : ?>
  <div class="mt-12 pb-12">
    <?php chaser_styled_sub_heading(array(
      'heading' => 'Discover More Streamers'
    )); ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
    <?php while ($moreStreamersQuery->have_posts()) : $moreStreamersQuery->the_post(); ?>
      <?php get_template_part('template-parts/card/card', 'streamer'); ?>
    <?php endwhile; ?>
    </div>
  </div>
  <?php endif; ?>

  <?php get_template_part('template-parts/section/latest-posts-review', null, array(
    'exclude' => array(get_the_ID())
  )); ?>

</div><!-- .container -->


<?php get_footer(); ?>