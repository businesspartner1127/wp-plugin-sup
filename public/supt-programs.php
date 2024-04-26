<?php
/**
 * Get all of programs from database
 */

$type = $_POST['type'];

require_once( '../../../../wp-load.php' );

global $wpdb;

$table_name = $wpdb->prefix . 'supt_university_data';

$temp_programs = $wpdb->get_results( "SELECT program FROM $table_name" );

$all_programs = array();

foreach ($temp_programs as $key => $value) {
	if ( !in_array( $value, $all_programs ) ) {
		array_push( $all_programs, $value );
	}
}

echo json_encode( $all_programs );