   <?php 
    $ts = $args['timestamp'];
    $type = get_post_type();
    // print_r($type); 
    // 'post'
   ?>
   
  <div class="info-pill-expiry" data-expiry="<?php echo esc_attr( $ts ); ?>">
    <div class="message active">
      <div class="message__body container">
        <div class="message__content">
          <h3 class="title">🗓️ This promotion <span class="ends-in-text"></span>.</h2>
        </div>
      </div>
    </div>
</div>