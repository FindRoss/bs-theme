  <?php get_template_part( 'template-parts/ad/ad-bottom' ); ?>
  </main>
  <footer class="border-top"> 
    <div style="background: #FAFAFA;">
      <div class="container py-5">
        <div class="row" style="font-size:1em">
          
          <div class="col-12 col-md-6 mb-4">
            <h2 class="h4">Socials</h2>
            <div class="footer-list__container">
              <ul>
                <li class="menu-item"><a target="_blank" href="https://twitter.com/intent/follow?screen_name=bitcoinchaser" aria-label="Follow BitcoinChaser on X">Twitter</a></li>
                <li class="menu-item"><a target="_blank" href="https://www.facebook.com/BitcoinChaser/" aria-label="Follow BitcoinChaser on Facebook">Facebook</a></li>
                <li class="menu-item"><a target="_blank" href="https://bitcoinchaser.com/feed/" aria-label="Join our RSS Feed">RSS Feed</a></li>
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
              <div class="mr-2 chaser-footer-title">BitcoinChaser</div>
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


