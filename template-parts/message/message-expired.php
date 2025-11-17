 <?php 
  $types = [
    'post'  => 'promotion',
    'bonus' => 'bonus',
  ];


  $type_output = $types[get_post_type()] ?? 'bonus';
  $text_output = "This " . $type_output . " has expired.";

  $expiry_ts   = $args['timestamp'] ?? null;  
  if ($expiry_ts) {
    $date_string = date('M j, Y', $expiry_ts);
    $text_output = "This " . $type_output . " expired on " . $date_string . ".";
  }
?>

<div role="status" aria-live="polite">
  <section class="message warning">
    <div class="message__body container">
      <div class="message__content">
        <p class="title">
          <?php echo $text_output; ?>
        </p>
      </div>
    </div>
  </section>
</div>
