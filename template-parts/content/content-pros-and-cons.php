<?php
$pros = $args['pac_pros'] ?? [];
$cons = $args['pac_cons'] ?? [];

if ($pros || $cons) : ?>
  <div class="bc-pc bc-pc--cols">

    <div class="bc-pc__grid">

      <?php if ($pros) : ?>
        <div class="bc-pc__panel bc-pc__panel--pros">
          <h3 class="bc-pc__label">Pros</h3>
          <ul class="bc-pc__list">
            <?php foreach ($pros as $row) : ?>
              <?php if (!empty($row['item'])) : ?>
                <li class="bc-pc__item">
                  <span class="bc-pc__badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M4 12.5L9.5 18L20 6.5"></path>
                    </svg>
                  </span>
                  <span class="bc-pc__text"><?php echo esc_html($row['item']); ?></span>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($cons) : ?>
        <div class="bc-pc__panel bc-pc__panel--cons">
          <h3 class="bc-pc__label">Cons</h3>
          <ul class="bc-pc__list">
            <?php foreach ($cons as $row) : ?>
              <?php if (!empty($row['item'])) : ?>
                <li class="bc-pc__item">
                  <span class="bc-pc__badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 5L19 19M19 5L5 19"></path>
                    </svg>
                  </span>
                  <span class="bc-pc__text"><?php echo esc_html($row['item']); ?></span>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

    </div>
  </div>
<?php endif; ?>
