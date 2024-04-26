<?php
/**
 * Get all of cities from database
 */

$type = $_POST['type'];

require_once( '../../../../wp-load.php' );

global $wpdb;

$table_name = $wpdb->prefix . 'supt_university_data';

$temp_cities = $wpdb->get_results( "SELECT city FROM $table_name" );

$all_cities = array();

foreach ($temp_cities as $key => $value) {
	if ( !in_array( $value, $all_cities ) ) {
		array_push( $all_cities, $value );
	}
}

echo json_encode( $all_cities );