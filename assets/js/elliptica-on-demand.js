/*
 * Source: http://codepen.io/desandro/pen/GFbAs
 */
/* jshint browser: true */
jQuery(document).ready(function( $ ) {
// Write in console log the PHP value passed in enqueue_js_vars in public/class-plugin-name.php

    var iso_grid = $('#elliptica_od_videos').isotope({
	  itemSelector: '.isotope_video_item',
  	  percentPosition: true,
	  masonry: {
		columnWidth: '.on_demand_video_grid-sizer'
	  }
	});

	var filters = {}; //store filters in an array
	$('.filters').on( 'click', '.button', function(event) {
	   var button = $( event.currentTarget );
		var base_url = window.location.origin;
		
	  // get group key
	  var buttonGroup = button.parents('.button-group');
	  var base_filter = buttonGroup.attr('id');
	  var params = [];
	$('.button-group').each(function() {
	    //other filters 
		if($(this).attr('id') === base_filter){
			params.push({ name: $(this).attr('id'), value: button.val() });
		}else{

			var current_button = '';
			$('#' + $(this).attr('id') + ' > button').each(function() {
				if($(this).hasClass('is-checked')){	
					current_button = $(this).val();
				}
			});
			params.push({ name: $(this).attr('id'), value: current_button });
		}
	});

		var fetch_url = base_url + '/wp-json/eod/v1/posts?' + $.param( params ); 
		console.log(fetch_url);
		fetch(fetch_url)
		  .then((response) => {
		    return response.json();
		  })
		  .then((posts) => {
				if(200 === posts.code){
					
					var data = posts.result;
					//console.log(data);
					data.forEach(function(post) {
					    console.log(post.id);
					});
				}else{
					return;
				}
		  });
	});

	// change is-checked class on buttons
	$('.button-group').each( function( i, buttonGroup ) {
	  var $buttonGroup = $( buttonGroup );
	  $buttonGroup.on( 'click', 'button', function( event ) {
		$buttonGroup.find('.is-checked').removeClass('is-checked');
		var button = $( event.currentTarget );
		button.addClass('is-checked');
	  });
	});

	// flatten object by concatting values
	function concatValues( obj ) {
	  var value = '';
	  for ( var prop in obj ) {
		value += obj[ prop ];
	  }
	  return value;
	}

	$('.info-popup').modaal();

	$(".mcd_playlist__show-more > a").on("click", function() {
    var self = $(this);
    var content = self.parent().prev(".modal-class-details__listwrap");
    var linkText = self.text().toUpperCase();

    if(linkText === "SHOW MORE"){
        linkText = "Show less";
        content.removeClass("mcd__playlist_hideContent", 400);
        content.addClass("mcd__playlist_showContent", 400);
    } else {
        linkText = "Show more";
        content.addClass("mcd__playlist_hideContent", 400);
        content.removeClass("mcd__playlist_showContent", 400);
    }

    self.text(linkText);
});
console.log('yes i am working...');
});
