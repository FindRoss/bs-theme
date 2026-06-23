<?php
$heading = $args['steps_heading'] ?? '';
$rows    = $args['steps_repeater'] ?? [];

if ($rows) : ?>
  <div class="bc-steps">

    <?php if ($heading) : ?>
      <div class="bc-blockhead">
        <h2 class="bc-blockhead__title"><?php echo esc_html($heading); ?></h2>
      </div>
    <?php endif; ?>

    <ul class="bc-steps__list">
      <?php foreach ($rows as $i => $row) : ?>
        <?php if (!empty($row['steps_content'])) : ?>
          <li class="bc-steps__item">
            <span class="bc-steps__num"><?php echo esc_html($i + 1); ?></span>
            <span class="bc-steps__body"><?php echo wp_kses_post($row['steps_content']); ?></span>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>

  </div>
<?php endif; ?>
