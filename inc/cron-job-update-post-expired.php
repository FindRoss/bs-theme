<?php 

function update_all_post_is_active_batch() {


    $batch_size = 75;
    $offset     = (int) get_option('post_update_offset', 0);

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $batch_size,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'offset'         => $offset,
        'no_found_rows'  => true,
        'orderby'        => 'ID',
        'order'          => 'ASC',
        // 'meta_key'       => 'expiry_date',
    );

    $bonuses = get_posts($args);

    if (!empty($bonuses)) {
        foreach ($bonuses as $post_id) {
            $expiration_date = get_field('expiry_date', $post_id);

            // Skip if field is missing or empty
            if (!$expiration_date) {
                continue;
            }

            $expired = (strtotime($expiration_date) < time());

            // Only update if value has changed (avoids unnecessary DB writes)
            $current_value = get_field('bonus_expired', $post_id);
            if ($current_value != $expired) {
                update_field('bonus_expired', $expired, $post_id);
            }
        }

        update_option('post_update_offset', $offset + $batch_size);
    } else {
        // Done with all posts
        update_option('post_update_offset', 0);
    }

}
