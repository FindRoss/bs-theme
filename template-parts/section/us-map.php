<?php
$statuses = $args['statuses'] ?? array();
$states   = $args['states'] ?? array();

if ( empty( $statuses ) || empty( $states ) ) return;
?>

<hr />

<div class="us-map">

  <div class="sec-head">
    <div class="sec-head__l">
      <span class="sec-head__bar"></span>
      <div class="sec-head__titles">
        <h2 class="sec-head__title">State Gambling Regulations</h2>
      </div>
    </div>
  </div>

  <p class="us-map__intro">An interactive map of the US states, showing where online casino gambling and online sports betting are legal. Hover or tap a state to see its current status.</p>

  <div class="us-map__figure">
    <?php include get_theme_file_path( '/template-parts/section/us-map/us-map-shape.svg' ); ?>
    <div class="us-map__tooltip" role="tooltip" hidden></div>
  </div>

  <ul class="us-map__legend">
    <?php foreach ( $statuses as $slug => $label ) : ?>
      <li class="us-map__legend-item">
        <span class="us-map__legend-swatch" data-status="<?php echo esc_attr( $slug ); ?>"></span>
        <span><?php echo esc_html( $label ); ?></span>
      </li>
    <?php endforeach; ?>
  </ul>

  <script type="application/json" class="us-map__data">
    <?php echo wp_json_encode( array( 'states' => $states, 'statuses' => $statuses ) ); ?>
  </script>

</div>

<hr />
