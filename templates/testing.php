<?php
/*
Template Name: Testing
Template Post Type: page
*/
get_header();

if ( ! current_user_can( 'manage_options' ) ) {
  wp_die( 'Not allowed.' );
}

global $wpdb;

$post_results = $wpdb->get_results( "
  SELECT p.ID, p.post_title, p.post_type, p.post_status, pm.meta_key
  FROM {$wpdb->posts} p
  JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
  WHERE pm.meta_key IN ('faqs_heading', 'faqs_description')
  AND pm.meta_value != ''
  AND p.post_status NOT IN ('auto-draft', 'trash', 'inherit')
  ORDER BY p.ID
" );

$taxonomies = ['cryptocurrency', 'game', 'provider', 'payment', 'country', 'type'];
$placeholders = implode( ',', array_fill( 0, count( $taxonomies ), '%s' ) );

$term_results = $wpdb->get_results( $wpdb->prepare( "
  SELECT t.term_id, t.name, tt.taxonomy, tm.meta_key
  FROM {$wpdb->terms} t
  JOIN {$wpdb->term_taxonomy} tt ON tt.term_id = t.term_id
  JOIN {$wpdb->termmeta} tm ON tm.term_id = t.term_id
  WHERE tt.taxonomy IN ($placeholders)
  AND tm.meta_key IN ('faqs_heading', 'faqs_description')
  AND tm.meta_value != ''
  ORDER BY tt.taxonomy, t.name
", ...$taxonomies ) );
?>

<div class="container" style="padding: 2rem 0 4rem;">
  <h1>FAQs Field Audit — Posts</h1>

  <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%;margin-top:1rem">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Field</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php if ( $post_results ) : foreach ( $post_results as $row ) : ?>
        <tr>
          <td><?php echo (int) $row->ID; ?></td>
          <td><?php echo esc_html( $row->post_title ); ?></td>
          <td><?php echo esc_html( $row->post_type ); ?></td>
          <td><?php echo esc_html( $row->post_status ); ?></td>
          <td><code><?php echo esc_html( $row->meta_key ); ?></code></td>
          <td><a href="<?php echo esc_url( get_edit_post_link( $row->ID ) ); ?>">Edit</a></td>
        </tr>
      <?php endforeach; else : ?>
        <tr><td colspan="6"><em>None found.</em></td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <h1 style="margin-top:3rem">FAQs Field Audit — Taxonomy Terms</h1>

  <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%;margin-top:1rem">
    <thead>
      <tr>
        <th>Term ID</th>
        <th>Name</th>
        <th>Taxonomy</th>
        <th>Field</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php if ( $term_results ) : foreach ( $term_results as $row ) : ?>
        <tr>
          <td><?php echo (int) $row->term_id; ?></td>
          <td><?php echo esc_html( $row->name ); ?></td>
          <td><?php echo esc_html( $row->taxonomy ); ?></td>
          <td><code><?php echo esc_html( $row->meta_key ); ?></code></td>
          <td><a href="<?php echo esc_url( get_edit_term_link( $row->term_id, $row->taxonomy ) ); ?>">Edit</a></td>
        </tr>
      <?php endforeach; else : ?>
        <tr><td colspan="5"><em>None found.</em></td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php get_footer(); ?>
