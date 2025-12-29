<?php
// Load values and assign defaults.
$casino_list = get_field('casino_list') ?? [];
?>

<?php if (!empty($casino_list)) : ?>
  <ul class="casino-list">
    <?php foreach ($casino_list as $item) :

      $text = $item['text'] ?? '';
      $casino_id = $item['casino'] ?? null;

      if (!$casino_id) continue; // skip if no casino ID

      // Review fields
      $details_group = get_field('details_group', $casino_id) ?? [];
      $name = $details_group['name'] ?? '';
      $link = $details_group['affiliate_link'] ?? '';

      if (!$name || !$link) continue; // skip if essential data missing
    ?>
      <li>
        <?php echo esc_html($text); ?> - 
        <a target="_blank" rel="nofollow" href="<?php echo esc_url($link); ?>">
          <?php echo esc_html($name); ?> 
          <?php echo get_svg_icon('external-link'); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
