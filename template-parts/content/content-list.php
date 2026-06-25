<?php
$heading = $args['list_heading'] ?? '';
$rows    = $args['list_repeater'] ?? [];
$type    = $args['list_type'] ?? 'arrow';

if ($rows) : ?>
  <div class="bc-content-list bc-content-list--<?php echo esc_attr($type); ?>">

    <?php if ($heading) : ?>
      <div class="bc-blockhead">
        <h2 class="bc-blockhead__title"><?php echo esc_html($heading); ?></h2>
      </div>
    <?php endif; ?>

    <ul class="bc-content-list__list">
      <?php foreach ($rows as $index => $row) : ?>
        <?php if (!empty($row['bc_list_item'])) : ?>
          <li class="bc-content-list__item">
            <?php if ($type === 'numbered') : ?>
              <span class="bc-content-list__icon bc-content-list__number" data-number="<?php echo esc_attr($index + 1); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="4" y1="9" x2="20" y2="9"></line>
                  <line x1="4" y1="15" x2="20" y2="15"></line>
                  <line x1="10" y1="3" x2="8" y2="21"></line>
                  <line x1="16" y1="3" x2="14" y2="21"></line>
                </svg>
              </span>
            <?php elseif ($type === 'arrow') : ?>
              <span class="bc-content-list__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </span>
            <?php elseif ($type === 'check') : ?>
              <span class="bc-content-list__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
              </span>
            <?php elseif ($type === 'steps') : ?>
              <span class="bc-content-list__num"><?php echo esc_html($index + 1); ?></span>
            <?php endif; ?>
            <span class="bc-content-list__body"><?php echo wp_kses_post($row['bc_list_item']); ?></span>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>

  </div>
<?php endif; ?>
