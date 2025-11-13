 <?php 
  $post_type   = get_post_type(); 
  $type_output = 'bonus';
  $expiry_ts   = $args['timestamp'];  


  if ($post_type == 'post') $type_output = 'promotion';  

  $text_output = "This " . $type_output . " has expired.";

  // print_r($expiry_ts); 
  // is equal to 1751327940

  if ($expiry_ts) {
    $date_string = date('M j', $expiry_ts);
    $text_output .= " It expired on <span class='time'>" . $date_string . "</span>";
  }
?>
   <div>
    <div class="message warning">
      <div class="message__body container">
        <div class="message__content">
          <h3 class="title"><?php echo $text_output; ?></h3>
        </div>
      </div>
    </div>
  </div>