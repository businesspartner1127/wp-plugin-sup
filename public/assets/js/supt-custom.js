/**
 * Search University Program frontend custom Script
 */

jQuery(document).ready(function($) {

	/**
	 * Function to get all of cities from database
	 */
	function getAllCities() {

		var plugUrl = $('#supt_blank').attr('supt_url');

		$.ajax({
			type: "POST",
           	url: plugUrl + 'public/supt-cities.php',
           	data: {type: 'city'}, 
           	success: function(response) {
            	if ( response ) {console.log(response);
            		var temp = JSON.parse( response );
            		var city_list = {};
            		for (var i = 0; i < temp.length; i++) {
            			var city = temp[i]['city'];
            			city_list[i] = city;
            		}
            		$('#supt_blank').attr('supt_cities', JSON.stringify( city_list ));
            	} else {
            		console.log( 'Failed' );
            	}
        	}
        });

	}

	/**
	 * Function to get all of programs from database
	 */
	function getAllPrograms() {

		var plugUrl = $('#supt_blank').attr('supt_url');

		$.ajax({
			type: "POST",
           	url: plugUrl + 'public/supt-programs.php',
           	data: {type: 'program'}, 
           	success: function(response) {
            	if ( response ) {
            		var temp = JSON.parse( response );
            		var program_list = {};
            		for (var i = 0; i < temp.length; i++) {
            			var program = temp[i]['program'];
            			program_list[i] = program;
            		}
            		$('#supt_blank').attr('supt_programs', JSON.stringify( program_list ));
            	} else {
            		console.log( 'Failed' );
            	}
        	}
        });

	}

	/**
	 * Function to get all of universities from database
	 */
	function getAllUniversities() {

		var plugUrl = $('#supt_blank').attr('supt_url');

		$.ajax({
			type: "POST",
           	url: plugUrl + 'public/supt-universities.php',
           	data: {type: 'university'}, 
           	success: function(response) {
            	if ( response ) {
            		var temp = JSON.parse( response );
            		var un_list = {};
            		for (var i = 0; i < temp.length; i++) {
            			var un = temp[i]['university'];
            			un_list[i] = un;
            		}
            		$('#supt_blank').attr('supt_universities', JSON.stringify( un_list ));
            	} else {
            		console.log( 'Failed' );
            	}
        	}
        });

	}

	if ( $('#supt_blank').length ) {
		getAllCities();
		getAllPrograms();
		if ( $('#supt_blank').attr('un_status') == 'on' ) {
			getAllUniversities();
		}
	}

	/**
	 * Input fields required
	 */
	$('#supt_submit').on('click', function(e) {

		e.preventDefault();

		$('#supt_program').removeClass('error');
		$('#supt_city').removeClass('error');

		var program = $.trim( $('#supt_program').val() );
		var city = $.trim( $('#supt_city').val() );

		if ( program == '' && city == '' ) {
			$('#supt_program').addClass('error');
			$('#supt_city').addClass('error');
			$('#supt_program').focus();
		} else {
			$('#supt_program').val(program);
			$('#supt_city').val(city);
			$('#supt_search_form').submit();
		}

	});


	/**
     * Left side trim function
     */
	function ltrim( str ) {
		if ( !str ) return str;
		return str.replace( /^\s+/g, '' );
	}

	/**
     * Input autocomplete function
     */
    $('.supt_keyword').on('keyup', function() {

    	var id = $(this).attr('id');

    	var keyword = ltrim( $(this).val() );
    	$(this).val(keyword);

    	if ( id == 'supt_city' ) {

	    	var temp_cities = $('#supt_blank').attr('supt_cities');
	    	var cities = JSON.parse( temp_cities );
	    	var count = Object.keys( cities ).length;
	    	var c = 0;
	    	if ( keyword.length >= 2 ) {
	    		$('#auto_city ul.auto_list').empty();
	    		for (var i = 0; i < count; i++) {
	    			if ( cities[i].toLocaleLowerCase('tr').startsWith( keyword.toLocaleLowerCase('tr') ) ) {
	    				$('#auto_city ul.auto_list').append( '<li class="child">' + cities[i] + '</li>' ); 
	    				c ++;
	    			}
	    		}
	    		if ( c > 0 ) {
	    			$('#auto_city').addClass('active');
	    		} else {
	    			$('#auto_city').removeClass('active');
	    		}
	    	} else {
	    		$('#auto_city').removeClass('active');
	    	}

	    } else {

	    	var temp_programs = $('#supt_blank').attr('supt_programs');
	    	var programs = JSON.parse( temp_programs );
	    	var count = Object.keys( programs ).length;
	    	var c = 0;
	    	if ( keyword.length >= 3 ) {
	    		$('#auto_program ul.auto_list').empty();
	    		for (var i = 0; i < count; i++) {
	    			if ( programs[i].toLocaleLowerCase('tr').includes( keyword.toLocaleLowerCase('tr') ) ) {
	    				$('#auto_program ul.auto_list').append( '<li class="child">' + programs[i] + '</li>' ); 
	    				c ++;
	    			}
	    		}
	    		if ( c > 0 ) {
	    			$('#auto_program').addClass('active');
	    		} else {
	    			$('#auto_program').removeClass('active');
	    		}
	    	} else {
	    		$('#auto_program').removeClass('active');
	    	}

	    }

    });


    /**
     * Input click function
     */
    $('.supt_keyword').on('click', function() {

    	var id = $(this).attr('id');
    	if ( id == 'supt_program' ) {
    		$('#auto_city').removeClass('active');
    	} else if ( id == 'supt_city' ) {
    		$('#auto_program').removeClass('active');
    	}

    });


    /**
     * Input autocomplete list click function
     */
    $('#supt_search_form ul.auto_list').on('click', 'li.child', function() {

    	var parent = $(this).closest('.autocomplete').attr('id');
    	var data = $(this).text();
    	if ( parent == 'auto_city' ) {
    		$('#supt_city').val(data);
    		$('#auto_city').removeClass('active');
    	} else {
    		$('#supt_program').val(data);
    		$('#auto_program').removeClass('active');
    	}

    });


    /**
     * Autocomplet list hide function
     */
    $('body').click(function(e) {

       	if ( e.target.id == 'supt_program' || e.target.id == 'auto_program' || e.target.id == 'supt_city' || e.target.id == 'auto_city' ) return;
       	$('#supt_search_form .autocomplete').removeClass('active');

	});

});