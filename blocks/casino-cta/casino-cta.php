<?php
// Field from block
$id = get_field('casino'); 
$text = get_field('text');

// Review fields
$details_group = $id ? get_field('details_group', $id) : null;
$link          = is_array($details_group) && !empty($details_group['affiliate_link']) ? $details_group['affiliate_link'] : null;
// $closed         = is_array($details_group) && !empty($details_group['closed']) ? $details_group['closed'] : null;

if ($link !== null): ?>
  <a class="button button__primary mt-3" rel="nofollow" href="<?php echo esc_url($link); ?>" target="_blank">
    <?php echo esc_html($text ? $text : "Play"); ?>
  </a>
<?php endif; ?>