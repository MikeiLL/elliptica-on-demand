/*
 * Source: http://codepen.io/desandro/pen/GFbAs
 */
jQuery(document).ready(function( $ ) {
// Write in console log the PHP value passed in enqueue_js_vars in public/class-plugin-name.php

    var iso_grid = $('#elliptica_od_videos').isotope({
	  itemSelector: '.od-video',
  	  percentPosition: true,
	  masonry: {
		columnWidth: 450
	  }
	});

	$('.filter-button-group').on( 'click', 'button', function() {
	  var filterValue = $(this).attr('data-filter');
	  console.log("got " + filterValue);
	  iso_grid.isotope({ filter: filterValue });
	});

});
