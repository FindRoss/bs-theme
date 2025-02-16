<?php 
function bonus_expired_meta_query() {
	return array(
		'relation' => 'AND',
		array(
			'key'     => 'bonus_expired',
			'value'   => '1',
			'compare' => '!='
		),
		array(
			'relation' => 'OR', 
			array(
				'key'     => 'expiry_date', 
				'value'   => current_time('mysql'), // Current date and time in 'Y-m-d H:i:s' format
				'compare' => '>',
				'type'    => 'DATETIME', // Ensure it's stored in 'Y-m-d H:i:s'
			),
			array(
				'key'     => 'expiry_date',
				'value'   => '',   // Empty value for no expiry date
				'compare' => '='
			),
		),
	);
}