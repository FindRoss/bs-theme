<?php
// Load values and assign defaults.
$casino_id  = get_field( 'casino' ); 

// Review fields
$details_group = get_field('details_group', $casino_id );
$name          = $details_group['name']; 
$link          = $details_group['affiliate_link']; 


$permalink  = get_permalink($casino_id);
?>

<p>Want to learn more about <?php echo $name; ?>? <strong>Read our <a href="<?php echo $permalink ?>"><?php echo $name; ?> review</a></strong>.</p>

<div class="mt-3">
  <a href="<?php echo $link; ?>" rel="nofollow" target="_blank" class="button button__primary">Visit <?php echo $name; ?></a>
</div>



