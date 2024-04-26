/**
 * Search University Program admin custom Script
 */

jQuery(document).ready(function($) {

	function copyToClipboard( element ) {

		var $temp = $("<input>");
  	    $("body").append($temp);
  	    $temp.val(element).select();
  	    document.execCommand("copy");
  	    $temp.remove();

	}

	$('#supt_shortcode').on('click', function() {

		var content = $(this).val();
      	var element = $('.supt_short_text').text();
      	copyToClipboard( element );
      	$(this).val("Copied!");
      	setTimeout(function() {
        	$('#supt_shortcode').val(content);
     	}, 1200);

	});

});