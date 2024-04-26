<?php

require_once( '../../../../wp-load.php' );

$target_dir = SUPT_PLUGIN_DIR . '/upload/';
$target_file = $target_dir . uniqid() . basename( $_FILES['supt_file_upload']['name'] );
$uploadOk = 1;

$imageFileType = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );

/* Check file size */
if ( $_FILES['supt_file_upload']['size'] > 5000000 ) {
  	echo 'Sorry, your file is too large.';
  	$uploadOk = 0;
}

/* Allow certain file formats */
if ( $imageFileType != 'xlsx' ) {
  	echo 'Sorry, only xlsx format is allowed.';
  	$uploadOk = 0;
}

/* Check if $uploadOk is set to 0 by an error */
if ( $uploadOk == 0 ) {
  	echo 'Sorry, your file was not uploaded.';
/* if everything is ok, try to upload file */
} else {
  	if ( move_uploaded_file( $_FILES['supt_file_upload']['tmp_name'], $target_file ) ) {
    	echo 'The file '. htmlspecialchars( basename( $_FILES['supt_file_upload']['name'] ) ) . ' has been uploaded.';
  	} else {
    	echo 'Sorry, there was an error uploading your file.';
  	}
}


error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
include SUPT_PLUGIN_DIR . '/admin/Classes/PHPExcel/IOFactory.php';

$objPHPExcel = PHPExcel_IOFactory::load( $target_file );

echo '<hr />';

$sheetData = $objPHPExcel->getActiveSheet()->toArray( null, true, true, true );
/*var_dump( $sheetData );*/

function removeNbsp($str) {
	$string = htmlentities( $str, null, 'utf-8' );
	$content = str_replace( "&nbsp;", " ", $string );
	$content = html_entity_decode( $content );
	return trim( $content );
}

global $wpdb;

$table_name = $wpdb->prefix . 'supt_university_data';

$wpdb->query( "TRUNCATE TABLE `$table_name`" );

foreach ($sheetData as $key => $value) {

	if ( $key != 1 ) {

		$un_type = true;

		if ( removeNbsp( $value['C'] ) == 'Devlet Üniversitesi' ) {
			$un_type = true;
		} else {
			$un_type = false;
		}

		$wpdb->insert( 
			$table_name, 
			array( 
				'city' 			=> removeNbsp( $value['A'] ), 
				'university' 	=> removeNbsp( $value['B'] ), 
				'un_type' 		=> $un_type, 
				'institute' 	=> removeNbsp( $value['D'] ), 
				'program' 		=> removeNbsp( $value['E'] ), 
				'thesis' 		=> $value['F'], 
				'edu_lang' 		=> $value['G'], 
				'edu_type' 		=> $value['H'], 
				'app_date' 		=> $value['I'], 
				'app_date_link'	=> $value['J'], 
				'edu_fee' 		=> $value['K'], 
				'edu_fee_link' 	=> $value['L'], 
				'note' 			=> $value['M'], 
			) 
		);

	}

}

echo '<script>history.go(-1);</script>';