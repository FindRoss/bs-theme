<?php
$breadcrumb_items = get_breadcrumb_items();

$link_output = '';
foreach ($breadcrumb_items as $item) {
  if (!empty($item['url'])) {
    $link_output .= '<span class="breadcrumbs__layout--item"><a class="cat-pill" href="' . esc_url($item['url']) . '">' . esc_html($item['name']) . '</a></span>';
  } else {
    $link_output .= '<span class="breadcrumbs__layout--item">' . esc_html($item['name']) . '</span>';
  }
}
?>


<?php if ($link_output !== "") : ?>
  <nav class="breadcrumbs container" aria-label="Breadcrumb">
    <div class="breadcrumbs__layout">
      <?php echo $link_output; ?>
    </div>
  </nav>
<?php else : ?>
  <div style="padding-block: 1rem"></div>
<?php endif; ?>
