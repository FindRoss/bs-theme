<?php 
function bonus_expired_meta_query() {
	return array(
		array(
			'key'     => 'bonus_expired',
			'value'   => '1',
			'compare' => '!='
		)
	);
}