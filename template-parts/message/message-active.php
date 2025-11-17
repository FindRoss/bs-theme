<?php 
  $types = [
    'post'  => 'promotion',
    'bonus' => 'bonus',
  ];

  $type_output = $types[get_post_type()] ?? 'bonus';
  $ts = $args['timestamp'] ?? null;
  $ts_js = $ts ? $ts * 1000 : null;
?>
   
<div class="info-pill-expiry" data-expiry="<?php echo esc_attr($ts_js); ?>" role="status" aria-live="polite">
  <section class="message active">
    <div class="message__body container">
      <div class="message__content">
        <p class="title">
          This <?php echo $type_output; ?> is active. It <span class="ends-in-text"></span>.
        </p>
      </div>
    </div>
  </section>
</div>
