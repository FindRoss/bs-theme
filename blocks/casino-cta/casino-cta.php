<?php
// Field from block
$casino_id = get_field( 'casino' ); 
$text      = get_field( 'text' );

// Review fields
$details_group = get_field('details_group', $casino_id );
$link          = $details_group['affiliate_link']; 

?>

<a class="button button__primary mt-3" rel="nofollow" href="<?php echo $link; ?>" target="_blank"><?php echo $text ? $text : "Play"; ?></a>
 
 


