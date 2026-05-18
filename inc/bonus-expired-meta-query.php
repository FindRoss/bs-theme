<?php 
function bonus_expired_meta_query() {
	return array(
		'relation' => 'OR',
		array(
			'key'     => 'bonus_expired',
			'value'   => '1',
			'compare' => '!='
		),
		array(
			'key'     => 'bonus_expired',
			'compare' => 'NOT EXISTS'
		),
	);
}