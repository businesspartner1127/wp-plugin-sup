<?php
/**
 * Search University Program - Data Upload screen
 */
?>

<div id="supt_upload_wrap" class="wrap">

	<h1><?php _e( '<strong>Upload Data</strong>', 'ss-supt' ); ?></h1>
	<hr />
	<div class="supt_upload_content">

		<form action="<?php echo SUPT_PLUGIN_URL; ?>admin/supt-file.php" method="post" enctype="multipart/form-data">
			<input type="file" id="supt_file_upload" name="supt_file_upload" class="supt_file_upload" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
			<input id="supt_upload" class="supt_upload button button-primary" type="submit" name="supt_upload" value="<?php esc_html_e( 'Upload', 'ss-supt' ); ?>">
		</form>

	</div>

</div>