<?php
$locations   = get_nav_menu_locations();
$menu_id     = $locations['homepage_icons'] ?? 0;
$menu_items  = $menu_id ? wp_get_nav_menu_items( $menu_id ) : array();

if ( empty( $menu_items ) ) return;
?>
<div class="icon-nav-band">
  <section class="icon-nav container">
    <div class="icon-nav__intro">
      <h1 class="icon-nav__heading">Play Safe.<span class="icon-nav__heading-break"></span>Play Smart.<span class="icon-nav__heading-break"></span>Play Crypto.</h1>
      <p class="icon-nav__body">Bitcoin casinos, crypto betting guides, and exclusive bonuses — since 2013.</p>
    </div>
    <ul class="icon-nav__grid">
      <?php foreach ( $menu_items as $item ) :
        $icon_url = null;
        if ( $item->type === 'taxonomy' ) {
          $icon = get_field( 'icon', 'term_' . $item->object_id );
        } elseif ( $item->type === 'post_type' ) {
          $icon = get_field( 'icon', $item->object_id );
        } else {
          $icon = null;
        }
        if ( $icon && is_array( $icon ) ) {
          $icon_url = $icon['sizes']['thumbnail'] ?? $icon['url'];
        }
      ?>
      <li>
        <a href="<?php echo esc_url( $item->url ); ?>" class="icon-nav__item">
          <span class="icon-nav__chip">
            <?php if ( $icon_url ) : ?>
              <img src="<?php echo esc_url( $icon_url ); ?>" width="28" height="28" alt="" aria-hidden="true" loading="eager" fetchpriority="high">
            <?php else : ?>
              <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" width="24" height="24"><circle cx="16" cy="16" r="10"/><path d="M16 12v4l3 3"/></svg>
            <?php endif; ?>
          </span>
          <span class="icon-nav__label"><?php echo esc_html( $item->title ); ?></span>
          <span class="icon-nav__arrow" aria-hidden="true">→</span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </section>
</div>
