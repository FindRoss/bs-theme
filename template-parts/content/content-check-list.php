<?php
$heading = $args['check_list_heading'] ?? '';
$rows    = $args['check_list_repeater'] ?? [];
$layout  = $args['check_list_layout'] ?? 'row';

if ($rows) : ?>
  <div class="bc-checklist">

    <?php if ($heading) : ?>
      <div class="bc-blockhead">
        <h2 class="bc-blockhead__title"><?php echo esc_html($heading); ?></h2>
      </div>
    <?php endif; ?>

    <ul class="bc-checklist__list<?php echo $layout === 'column' ? ' bc-checklist__list--column' : ''; ?>">
      <?php foreach ($rows as $row) : ?>
        <?php if (!empty($row['check_list_content'])) : ?>
          <li class="bc-checklist__item">
            <span class="bc-checklist__check"><svg class="bc-ico"><use href="#i-check"></use></svg></span>
            <span class="bc-checklist__body"><?php echo wp_kses_post($row['check_list_content']); ?></span>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>

  </div>
<?php endif; ?>
