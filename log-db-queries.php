<?php
/**
 * Logs database queries to a file for debugging.
 * Filters out known benign queries to reduce noise.
 */

add_filter( 'query', function( $query ) {

	// Filter out everything that shouldn't be logged.
	if ( 
		stripos( $query, 'SELECT' ) !== FALSE ||
		stripos( $query, 'SHOW' ) !== FALSE ||
		stripos( $query, '_transient_' ) !== FALSE ||
		stripos( $query, 'wp_yoast_notifications' ) !== FALSE ||
		stripos( $query, "WHERE `option_name` = 'cron'" ) !== FALSE ||
		stripos( $query, 'wp_actionscheduler' ) !== FALSE ||
		stripos( $query, 'action_scheduler' ) !== FALSE
	) {
		return $query;
	}

	$file = WP_CONTENT_DIR . '/sql.log'; // Edit this filepath.
	@file_put_contents(
		$file,
		date( 'c' ) . ' - ' . $query . PHP_EOL,
		FILE_APPEND | LOCK_EX
	);

	return $query;
}, PHP_INT_MAX );

