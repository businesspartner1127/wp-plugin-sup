<?php
/**
 * Search University Program admin area
 */
?>

<div id="supt_wrap" class="wrap">
	
	<div class="supt_badge"></div>
	<h1 class="wp-heading-inline"><?php printf( __( '<strong>Search University Program</strong> <small>v.</small>%s', 'ss-supt' ), SUPT_VERSION );; ?></h1>
	<hr />
	<div class="supt_content">
		<span class="supt_short_title"><?php esc_html_e( 'Shortcode', 'ss-supt' ); ?></span>
		<span class="supt_short_text"><?php esc_html_e( '[Search-University]', 'ss-supt' ); ?></span>
		<span class="supt_short_copy">
			<input id="supt_shortcode" class="supt_shortcode button button-primary" type="button" name="supt_shortcode" value="<?php esc_html_e( 'Copy', 'ss-supt' ); ?>">
		</span>
	</div>

</div>