  <?php get_template_part( 'template-parts/ad/ad-bottom' ); ?>
  </main>
  <footer class="border-top">
    <div style="background: #FAFAFA;">
      <div class="container py-5">

        <div class="footer-top-row mb-5">
          <a href="/" aria-label="BitcoinChaser home">
            <img src="https://bitcoinchaser.com/wp-content/uploads/2014/06/bitcoinchaser_logo-03.png"
                 width="180" height="22"
                 alt="BitcoinChaser logo">
          </a>
          <div class="footer-social-icons">
            <a href="https://twitter.com/intent/follow?screen_name=bitcoinchaser" aria-label="Follow BitcoinChaser on X" target="_blank">
              <svg height="40" width="40" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>X</title>
                <path fill="currentColor" d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
              </svg>
            </a>
            <a href="https://www.instagram.com/bitcoin_chaser/" aria-label="Follow BitcoinChaser on Instagram" target="_blank">
              <svg height="40" width="40" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>Instagram</title>
                <path fill="currentColor" d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm6.061 14.225c0 2.113-1.713 3.826-3.826 3.826H9.765c-2.113 0-3.826-1.713-3.826-3.826V9.765c0-2.113 1.713-3.826 3.826-3.826h4.47c2.113 0 3.826 1.713 3.826 3.826v4.46zM12 8.3c-2.043 0-3.7 1.657-3.7 3.7s1.657 3.7 3.7 3.7 3.7-1.657 3.7-3.7-1.657-3.7-3.7-3.7zm0 6.13a2.43 2.43 0 1 1 0-4.86 2.43 2.43 0 0 1 0 4.86zm3.864-6.494a.864.864 0 1 1-1.728 0 .864.864 0 0 1 1.728 0z"/>
              </svg>
            </a>
            <a href="https://www.facebook.com/BitcoinChaser" aria-label="Follow BitcoinChaser on Facebook" target="_blank">
              <svg height="40" width="40" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>Facebook</title>
                <path fill="currentColor" fill-rule="evenodd" d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm3.2 12.15h-2.18v7.6h-3.15v-7.6H8.25v-2.65h1.62V7.75c0-2.45 1.5-3.8 3.7-3.8 1.05 0 2 .08 2.25.12v2.6h-1.55c-1.2 0-1.42.57-1.42 1.4v1.43h2.88l-.38 2.65z"/>
              </svg>
            </a>
            <a href="https://t.me/bitcoinchasercom" aria-label="Join BitcoinChaser on Telegram" target="_blank">
              <svg height="40" width="40" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>Telegram</title>
                <path fill="currentColor" d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
              </svg>
            </a>
          </div>
        </div>

        <?php
          $footer_cols = array(
            array( 'location' => 'footer_articles',  'heading' => 'Articles' ),
            array( 'location' => 'footer_reviews',   'heading' => 'Reviews' ),
            array( 'location' => 'footer_games',     'heading' => 'Games' ),
            array( 'location' => 'footer_countries', 'heading' => 'Countries' ),
            array( 'location' => 'footer_bonuses',   'heading' => 'Bonuses' ),
            array( 'location' => 'footer_site',      'heading' => 'Site' ),
          );

          $has_any_col = false;
          foreach ( $footer_cols as $col ) {
            $menu_html = wp_nav_menu( array(
              'theme_location'  => $col['location'],
              'depth'           => 1,
              'container'       => 'div',
              'container_class' => 'footer-list__container',
              'menu_class'      => '',
              'fallback_cb'     => false,
              'echo'            => false,
            ) );
            if ( $menu_html ) { $has_any_col = true; break; }
          }
        ?>

        <?php if ( $has_any_col ) : ?>
        <div class="row">
          <?php foreach ( $footer_cols as $col ) :
            $menu_html = wp_nav_menu( array(
              'theme_location'  => $col['location'],
              'depth'           => 1,
              'container'       => 'div',
              'container_class' => 'footer-list__container',
              'menu_class'      => '',
              'fallback_cb'     => false,
              'echo'            => false,
            ) );
            if ( ! $menu_html ) continue;
          ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 footer-col">
              <h2 class="h4 footer-col__heading"><?php echo esc_html( $col['heading'] ); ?></h2>
              <?php echo $menu_html; ?>
            </div>
          <?php endforeach; ?>
        </div><!-- .row -->
        <?php endif; ?>

      </div><!-- .container -->
    </div>

    <div class="border-top" style="background: #EFEFEF;">
      <div class="container">
        <div class="row">
          <div class="col-12 d-flex align-items-center py-3" style="font-size: 0.85em;">
            <div class="mr-2 ff-main">BitcoinChaser</div>
            <div class="text-muted mr-2">&copy; <?php echo date('Y'); ?></div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- disabled Google fonts and Font Awesome from loading with OptinMonster -->
  <script type="text/javascript">
  document.addEventListener('om.Scripts.init', function(event) {
  event.detail.Scripts.enabled.fonts= false;
  });
  </script>
  <?php wp_footer(); ?>
  </body>
</html>
