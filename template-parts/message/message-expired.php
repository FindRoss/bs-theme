 <?php 
 
  $post_type   = get_post_type(); 
  $type_output = 'bonus';
  $button_link = '/bonuses/';

  if ($post_type == 'post') { 
    $type_output = 'promotion'; 
    $button_link = '/category/promotions/';
  } 
?>
   <div>
    <div class="message warning">
      <div class="message__body container">
        <div class="message__content">
          <h3 class="title">This <?php echo $type_output; ?> has now expired.</h2>
        </div>
      </div>
    </div>
  </div>


     <!-- <div>
    <div class="message warning">
      <div class="message__body container">
        <div class="message__content">
          <h3 class="title">This <?php echo $type_output; ?> has now expired.</h2>
          <p>Check out other exciting opportunities available now.</p>
        </div>
        <div class="message__cta">
          <a class="button button__primary" href="<?php echo $button_link; ?>">View More</a>
        </div>
      </div>
    </div>
  </div> -->