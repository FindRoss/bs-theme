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
    
   <?php if ($table_rows) : ?>
    <div class="main--table rank-table">
      <table id="toggle-table">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>Score</th>
          </tr>
        </thead>

        <tbody>
          <?php ob_start();
          $counter = 1; 

          foreach ($table_rows as $row) : 
          
            $review_id = $row['review'];

            // Detauls Group Fields
            $details_group = get_field('details_group', $review_id);
            $name = $details_group['name'];
            $affiliate_link = $details_group['affiliate_link'];
            $closed = $details_group['closed'];
            if ($closed) {
              continue; // Skip closed sites
            }

            // Media Group Fields
            $media_group = get_field('media_group', $review_id);
            $theme_color = get_field('theme_color', $review_id);

            // Default WordPress Fields
            $site_thumbnail = get_the_post_thumbnail_url($review_id, 'site-small-logo');
            $site_url = get_permalink($review_id);
            $unique_id = 'row-' . $counter;
            ?>

            <tr class="main-row" data-toggle-row="<?php echo $unique_id; ?>">
              <td>
                <button 
                  data-toggle-target="<?php echo $unique_id; ?>"
                  class="toggle-table-button round-icon"
                >
                  <?php echo get_svg_icon('chevron-down'); ?>
                </button>
              </td>
              <td class="rank center number-outline"><?php echo '#' . $counter; ?></td>
              <td class="brand"><img src="<?php echo $site_thumbnail; ?>" width="100" height="50" alt="<?php echo $name; ?> Logo" /></td>
              <td>1876</td>
            </tr>
            <tr class="sub-row hide d-none" data-toggle-content="<?php echo $unique_id; ?>">
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
    <?php endif; ?>

   </div>
</div>

<?php get_footer(); ?>

