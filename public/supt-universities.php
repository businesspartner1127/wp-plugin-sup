<?php
/**
 * Get all of universities from database
 */

$type = $_POST['type'];

require_once( '../../../../wp-load.php' );

global $wpdb;

$table_name = $wpdb->prefix . 'supt_university_data';

$temp_universities = $wpdb->get_results( "SELECT university FROM $table_name" );

$all_universities = array();

foreach ($temp_universities as $key => $value) {
	if ( !in_array( $value, $all_universities ) ) {
		array_push( $all_universities, $value );
	}
}

echo json_encode( $all_universities );