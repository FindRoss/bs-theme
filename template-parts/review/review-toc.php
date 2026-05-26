<?php
$toc = $args['toc'] ?? [];
if (count($toc) < 2) return;
?>
<nav class="review-toc" aria-label="On this page">
  <h6 class="review-toc__label">On this page</h6>
  <ul class="review-toc__list">
    <?php foreach ($toc as $item) : ?>
      <li class="review-toc__item">
        <a href="#<?php echo esc_attr($item['id']); ?>" class="review-toc__link">
          <?php echo esc_html($item['label']); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
