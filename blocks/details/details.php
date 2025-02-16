<?php
// Load values and assign defaults.
$site_id            = get_field( 'casino' ); 

if (empty($site_id)) return; 

$description        = get_field( 'description' );
$heading            = get_field( 'heading' );
$heading_level      = get_field( 'heading_level' );
$unique_link        = get_field( 'casino_details_link' );

// Review fields
$media_group   = get_field('media_group', $site_id);
$site_color    = $media_group['theme_color'];
// $homepage      = $media_group['homepage'];
$details_group = get_field('details_group', $site_id );
$link          = $details_group['affiliate_link']; 
$name          = $details_group['name']; 
$bonus         = $details_group['bonus']; 
$logo          = get_the_post_thumbnail_url($site_id, 'site-small-logo');

// homepage image
$permalink  = get_permalink($site_id);

?>

<div class="details-card">

  <div class="details-card__header">
    <?php if ($logo) { ?>
      <div class="logo-wrapper" style="background-color: <?php echo $site_color; ?>">
        <img width="135" height="auto" src="<?php echo $logo; ?>" alt="<?php echo $name . ' logo'; ?>">
      </div>
    <?php }; ?>

    <div class="title-wrapper">

      <?php if($heading) { ?>

        <?php if ($heading_level === "h2") : ?> 
          <h2><?php echo $name; ?>: <?php echo $heading; ?></h2>
        <?php elseif ($heading_level === "h3") : ?> 
          <h3><?php echo $name; ?>: <?php echo $heading; ?></h3>
        <?php endif; ?>      

      <?php } else { ?>

        <h2><?php echo $name; ?></h2>

      <?php } ?>

         <?php if($bonus) { 
          echo '<div class="bonus">';
          echo '<span>' . get_svg_icon('star') . 'Bonus:</span>';
          echo $bonus;
          echo '</div>';
        } ?>

    </div>

  </div>
    
  <?php if ($description) : ?><?php echo $description; ?><?php endif; ?> 

  <div class="details-card__ctas">
    <a class="button button__outline" href="<?php echo $permalink; ?>">Review</a>   
    <?php if ($link) { ?>
      <a class="button button__primary" rel="nofollow" href="<?php echo $unique_link ? $unique_link : $link; ?>" target="_blank">Play</a>
    <?php } ?>    
  </div>

</div>