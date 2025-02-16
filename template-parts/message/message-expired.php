 <?php 
 
  $post_type   = get_post_type(); 
  $type_output = 'bonus';

  if ($post_type == 'post') { $type_output = 'promotion'; } 
?>
 
 <div class="message warning">
    <div class="container">
      <div class="message__body">
        <div class="message__content">
          <h3 class="title">This <?php echo $type_output; ?> has now expired.</h2>
          <p>Check out other exciting opportunities available now.</p>
        </div>
        <div class="message__cta">
          <a class="button button__primary" href="/category/promotions/">View More</a>
        </div>
      </div>
    </div>
  </div>