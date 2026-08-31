<?php
    $explicit_author = isset($args['author_id']);

    // author
    $author_id = $explicit_author ? (int) $args['author_id'] : get_the_author_meta('ID');
    if (!$author_id) return;

    $author_name = get_the_author_meta('display_name', $author_id);
    $author_link = get_author_posts_url( $author_id );

    $publish_date = null;
    $update_date  = null;
    $update_datetime = null;

    if ($explicit_author) {
        // Term context: no publish date to show, only a tracked "last updated" date.
        $updated_at = $args['updated_at'] ?? null;
        if ($updated_at) {
            $update_date     = mysql2date('M j, Y', $updated_at);
            $update_datetime = mysql2date('c', $updated_at);
        }
    } else {
        // Get the publish and updated date to compare
        $publish_date_str = get_the_date('Y-m-d');
        $update_date_str  = get_the_modified_date('Y-m-d');

        $publish_ts = strtotime($publish_date_str);
        $update_ts  = strtotime($update_date_str);

        // Get formatted dates
        $publish_date = get_the_date('M j, Y');

        if ($update_ts > $publish_ts) {
            $update_date     = get_the_modified_date('M j, Y');
            $update_datetime = get_the_modified_date('c');
        }
    }
?>

<div class="main--published">
  <span>By <a href="<?php echo esc_url($author_link); ?>"><?php echo esc_html($author_name); ?></a></span>
  <?php if ($publish_date) : ?>
    <span><time datetime="<?php echo esc_attr( get_the_date('c') ); ?>"><?php echo esc_html( $publish_date ); ?></time></span>
  <?php endif; ?>
  <?php if ($update_date) : ?>
    <span>Updated <time datetime="<?php echo esc_attr( $update_datetime ); ?>"><?php echo esc_html( $update_date ); ?></time></span>
  <?php endif; ?>
</div>
