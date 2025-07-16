<?php
// Load values and assign defaults.
$casino_list = get_field('casino_list');
?>

<?php 
if($casino_list) { ?>
  <ul class="casino-list">
  <?php foreach($casino_list as $item) {
    $text      = $item['text'];
    $casino_id = $item['casino']; 
    

    // Review fields
    $details_group = get_field('details_group', $casino_id );
    $name          = $details_group['name']; 
    $link          = $details_group['affiliate_link']; 
 
  ?>
    <li>
      <?php echo $text ?> - 
      <a target="_blank" rel="nofollow" href="<?php echo $link; ?>">
        <?php echo $name; ?> 
        <?php echo get_svg_icon('external-link'); ?>
      </a>
    </li>
  <?php } ?>
  </ul>
<?php }

?>




