<?php 
/* 
Template Name: Power Index
Template Post Type: post, pages
*/ 
?>

<?php get_header(); ?>

<?php $table_rows = get_field('power_index'); ?>





<div class="container">
  <h1>Power Index</h1>
   <div class="main--content">
    
   <div class="main--table rank-table">
    <table>
      <thead>
        <tr>
          <th class="center">Rank</th>
          <th>Site</th>
          <th>Score</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        <?php ob_start();
        $counter = 1; 

        foreach ($table_rows as $row) : 
        
          $site_id = $row['site'];

          // Detauls Group Fields
          $details_group = get_field('details_group', $site_id);
          $name = $details_group['name'];
          $affiliate_link = $details_group['affiliate_link'];
          $closed = $details_group['closed'];
          if ($closed) {
            continue; // Skip closed sites
          }

          // Media Group Fields
          $media_group = get_field('media_group', $site_id);
          $theme_color = get_field('theme_color', $site_id);

          // Default WordPress Fields
          $site_thumbnail = get_the_post_thumbnail_url($site_id, 'site-small-logo');
          $site_url = get_permalink($site_id);
          ?>

          <tr>
            <td class="center"><?php echo '#' . $counter; ?></td>
            <td class="brand"><img src="<?php echo $site_thumbnail; ?>" width="100" height="50" alt="<?php echo $name; ?> Logo" /></td>
            <td>1876</td>
            <td>
              <button class="round-icon"><?php echo get_svg_icon('chevron-down'); ?></button>
            </td>
          </tr>
          <tr class="d-none">
            <td>Ahrefs Score</td>
            <td>Search Console</td>
            <td>Social Score</td>
          </tr>

          <?php $counter++; ?>
        <?php endforeach; ?>
        <?php echo ob_get_clean(); ?>
      </tbody>
    </table>
    </div>

   </div>
</div>

<?php get_footer(); ?>

