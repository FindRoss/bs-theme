<?php get_header(); ?>

<?php 
  $table_fields = array();

  $realName     = get_field('real_name');
  $streamerName = get_field('streamer_name');
  $dob          = get_field('date_of_birth');
  $games        = get_field('favorite_games');
  $socialGroup  = get_field('socials');
  $sites        = get_field('sites');

  $kick    = $socialGroup['kick'];
  $twitch  = $socialGroup['twitch'];
  $twitter = $socialGroup['x_twitter'];

  // String
  if (!empty($realName)) {
    $table_fields['Real name'] = $realName;
  }
  // String
  if (!empty($streamerName)) {
    $table_fields['Streaming name'] = $streamerName;
  }
  // Date
  if (isset($birthDate)) {
    //// Calc age from dob
    // Convert date of birth string to a DateTime object
    $birthDate = DateTime::createFromFormat('Ymd', $dob);
    // Get current date
    $currentDate = new DateTime();
    // Calculate difference between birth date and current date
    $age = $currentDate->diff($birthDate);
    // Get the difference in years
    $age = $age->y;

    $table_fields['Age'] = $age;
  }
  // String
  if (!empty($games)) {
    $table_fields['Favorite games'] = $games;
  }
  // String
  if (!empty($kick)) {
    $table_fields['Kick'] = '<a href="' . $kick . '" target="_blank">' . str_replace(array("http://", "https://"), "", $kick) . '</a>';
  }


  $moreStreamersQuery = new WP_Query(array(
    'post_type' => 'streamer',
    'posts_per_page' => 4,
    'post__not_in' => array(get_the_ID())
  ));
?>

<div class="container">

  <article class="py-3 py-lg-4">

    <div class="streamer-header">
      <div class="row">
        <div class="col-12 col-lg-6">
          <h1 class="main--title"><?php the_title(); ?></h1>
          <?php if (has_excerpt()) { ?>
            <p class="fs-large"><?php echo get_the_excerpt(); ?></p>
          <?php }; ?>
        </div>
        <div class="col-12 col-lg-6">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="w-100 h-auto" alt="">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-lg-8">
      

        <!-- Site -->
        <?php if (isset($sites) && is_array($sites)) : ?>
        <div class="mt-5">
          <h2>Plays at</h2>

          <?php foreach($sites as $site) { 

              $siteDetailsGroup = get_field('details_group', $site);
              $siteMediaGroup   = get_field('media_group', $site);
              $siteColor        = $siteMediaGroup['theme_color'];
              $siteName         = $siteDetailsGroup['name'];
              $siteLink         = $siteDetailsGroup['affiliate_link'];
              $siteLogo         = get_the_post_thumbnail_url($site, 'site-small-logo');
              $siteBonus        = $siteDetailsGroup['bonus'];
              $siteReviewLink   = get_the_permalink($site);

              ?>

            <div class="site-card">
              <div class="site-card__media" style="background-color: <?php echo $siteColor; ?>">
                <a href="<?php echo $siteReviewLink; ?>"><img src="<?php echo $siteLogo;  ?>" alt=""></a>
              </div>
              <div class="site-card__name">
                <a class="name" href="<?php echo $siteReviewLink; ?>"><h2><?php echo $siteName; ?></h2></a>
              </div>
              <div class="site-card__bonus">
                <div class="title">BONUS</div>
                <div class="bonus"><?php echo $siteBonus; ?></div>
              </div>
              <div class="site-card__buttons">
                <a class="button button__primary" href="<?php echo $siteLink; ?>">Play</a>
                <a class="" href="<?php echo $siteReviewLink; ?>">Read Review</a>
              </div>
            </div>

          <?php }; ?>
        </div>
        <?php endif; ?>    
    
        
        <?php if (!empty($table_fields)) { ?>
        <div class="streamer-table mt-5">
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
        
        <?php if (get_the_content()) { ?>
        <div class="streamer-content main--content mt-5">
          <?php the_content(); ?>
        </div>
        <?php }; ?>
      </div>
    </div>
  </article>

  <?php if ($moreStreamersQuery->have_posts()) : ?>
  <div class="mt-5 pb-5">
    <?php chaser_styled_sub_heading(array(
      'heading' => 'Discover More Streamers' 
    )); ?>
    <div class="row mt-4">
    <?php while ($moreStreamersQuery->have_posts()) : $moreStreamersQuery->the_post(); ?>
      <div class="col-12 col-md-6 col-lg-3 mt-4">
        <?php get_template_part('template-parts/card/card', 'streamer'); ?>
      </div><!-- .col --> 
    <?php endwhile; ?>
    </div><!-- .row --> 
  </div>
  <?php endif; ?>

</div><!-- .container -->


<?php get_footer(); ?>