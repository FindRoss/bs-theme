<?php 

function update_all_bonus_is_active_batch() {
    $batch_size = 100; // Number of posts to update per run
    $offset = (int) get_option('bonus_update_offset', 0);

    $args = [
        'post_type'      => 'bonus',
        'posts_per_page' => $batch_size,
        'post_status'    => 'any',
        'fields'         => 'ids',
        'offset'         => $offset,
    ];

    $bonuses = get_posts($args);

    if (!empty($bonuses)) {
        foreach ($bonuses as $post_id) {
            $expiration_date = get_field('expiry_date', $post_id); // or whatever your field is
            $expired = false;
            
            if ($expiration_date && strtotime($expiration_date) < time()) {
                $expired = true;
            }
            
            // Update the ACF field (true/false)
            update_field('bonus_expired', $expired, $post_id);
        }

        // Update offset for next batch
        update_option('bonus_update_offset', $offset + $batch_size);
    } else {
        // No more posts to process, reset offset
        update_option('bonus_update_offset', 0);
    }
}