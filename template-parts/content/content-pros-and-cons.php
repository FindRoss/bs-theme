<?php
$pros = $args['pac_pros'] ?? [];
$cons = $args['pac_cons'] ?? [];

if ($pros || $cons) : ?>
  <div class="bc-pc bc-pc--cols">

    <div class="bc-pc__grid">

      <?php if ($pros) : ?>
        <div class="bc-pc__panel bc-pc__panel--pros">
          <div class="bc-pc__label">
            <span class="bc-chip"><svg class="bc-ico"><use href="#i-check"></use></svg></span> Pros
          </div>
          <ul>
            <?php foreach ($pros as $row) : ?>
              <?php if (!empty($row['item'])) : ?>
                <li><span class="bc-mark"><svg class="bc-ico"><use href="#i-check"></use></svg></span><?php echo esc_html($row['item']); ?></li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($cons) : ?>
        <div class="bc-pc__panel bc-pc__panel--cons">
          <div class="bc-pc__label">
            <span class="bc-chip"><svg class="bc-ico"><use href="#i-x"></use></svg></span> Cons
          </div>
          <ul>
            <?php foreach ($cons as $row) : ?>
              <?php if (!empty($row['item'])) : ?>
                <li><span class="bc-mark"><svg class="bc-ico"><use href="#i-x"></use></svg></span><?php echo esc_html($row['item']); ?></li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

    </div>
  </div>
<?php endif; ?>
