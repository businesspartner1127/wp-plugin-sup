<?php
/**
 * Search University Program frontend Preview
 */

function supt_shortcode( $atts ) {

	$preview = '
		<div id="supt_search_form_wrapper" class="supt_search_form_wrapper">
			<h2>Üniversite Ara</h2>
			<form id="supt_search_form" class="supt_search_form" name="supt_search_form" method="GET" action="' . get_home_url() . '/search" autocomplete="off">
				<input type="text" name="supt_program" id="supt_program" class="supt_keyword" value="" placeholder="Program Adı">
				<div class="autocomplete auto_program" id="auto_program">
					<ul class="auto_list"></ul>
				</div>
				<input type="text" name="supt_city" id="supt_city" class="supt_keyword" value="" placeholder="Şehir">
				<div class="autocomplete auto_city" id="auto_city">
					<ul class="auto_list"></ul>
				</div>
				<input type="button" class="supt_btn" id="supt_submit" value="ARA">
			</form>
			<div id="supt_blank_wrapper">
				<div id="supt_blank" supt_url="' . SUPT_PLUGIN_URL . '"></div>
			</div>
		</div>
	';

	return $preview;

}