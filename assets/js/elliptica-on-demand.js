/*
 * Source: http://codepen.io/desandro/pen/GFbAs
 */
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
	  // get group key
	  var buttonGroup = button.parents('.button-group');
	  var filterGroup = buttonGroup.attr('data-filter-group');
	  // set filter for group
	  filters[ filterGroup ] = button.attr('data-filter');
	  // combine filters
	  var filterValue = concatValues( filters );
	  console.log(filterValue);
	  iso_grid.isotope({ filter: filterValue });
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
