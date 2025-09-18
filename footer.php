  <?php get_template_part( 'template-parts/ad/ad-bottom' ); ?>
  </main>
  <footer class="border-top"> 
    <div style="background: #FAFAFA;">
      <div class="container py-5">
        <div class="row" style="font-size:1em">
          
          <div class="col-12 col-md-6 mb-4">
            <h2 class="h4">Socials</h2>
            <div class="footer-list__container">
              <ul class="footer-social-icons">
                <li>
                  <a href="https://twitter.com/intent/follow?screen_name=bitcoinchaser" aria-label="Follow BitcoinChaser on X" target="_blank">
                    <svg height="40" width="40" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <title>X</title>
                      <path fill="currentColor" d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                    </svg>
                  </a>
                </li>
                <div>
                  <a href="https://t.me/bitcoinchasercom" aria-label="Join BitcoinChaser on Telegram" target="_blank">
                    <svg height="40" width="40" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <title>Telegram</title>
                      <path fill="currentColor" d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                  </a>
                </div>
                <div>
                  <a href="https://bitcoinchaser.com/feed/" aria-label="Join our RSS Feed" target="_blank">
                    <svg height="40" width="40" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <title>RSS</title>
                      <path fill="currentColor" d="M19.199 24C19.199 13.467 10.533 4.8 0 4.8V0c13.165 0 24 10.835 24 24h-4.801zM3.291 17.415c1.814 0 3.293 1.479 3.293 3.295 0 1.813-1.485 3.29-3.301 3.29C1.47 24 0 22.526 0 20.71s1.475-3.294 3.291-3.295zM15.909 24h-4.665c0-6.169-5.075-11.245-11.244-11.245V8.09c8.727 0 15.909 7.184 15.909 15.91z"/>
                    </svg>
                  </a>
                </div>
              </ul>
            </div>
          </div><!-- .col --> 
            
          <div class="col-12 col-md-3 mb-4">
            <?php $footer_menu_center_left = wp_nav_menu( array(
              'echo'            => false, 
              'menu'            => 'Footer Menu Center-Left',
              'depth'           => 1,
              'container'       => 'div',
              'container_class' => 'footer-list__container',
              'container_id'    => '',
              'menu_class'      => '',
              // 'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
              // 'walker'          => new WP_Bootstrap_Navwalker(),
              )); 
              
              if (!empty($footer_menu_center_left)) {
                echo '<h2 class="h4">Sections</h2>'; 
                echo $footer_menu_center_left; 
              } ?>
          </div>

          <div class="col-12 col-md-3 mb-4">
            <!-- .footer-list__container in css --> 
            <?php $footer_menu_left = wp_nav_menu( array(
              'echo'            => false, 
              'menu'            => 'Footer Menu Left',
              'depth'           => 1,
              'container'       => 'div',
              'container_class' => 'footer-list__container',
              'container_id'    => '',
              'menu_class'      => '',
              // 'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
              // 'walker'          => new WP_Bootstrap_Navwalker(),
              )); 
             
              if (!empty($footer_menu_left)) {
                echo '<h2 class="h4">Site</h2>'; 
                echo $footer_menu_left; 
              } ?>
          </div>
          
        </div><!-- .row --> 
      </div><!-- .container --> 
      </div>
      <div class="border-top" style="background: #EFEFEF;"> 
        <div class="container">
          <div class="row">
            <div class="col-12 d-flex align-items-center py-3" style="font-size: 0.85em;">
              <div class="mr-2 ff-main">BitcoinChaser</div>
              <div class="text-muted mr-2">&copy; <?php echo date('Y'); ?></div>
            </div><!-- .col --> 
          </div><!-- .row --> 
        </div><!-- .container --> 
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


