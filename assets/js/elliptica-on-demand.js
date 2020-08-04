/*
 * Source: http://codepen.io/desandro/pen/GFbAs
 */
jQuery(document).ready(function( $ ) {
// Write in console log the PHP value passed in enqueue_js_vars in public/class-plugin-name.php
    var container = $('#elliptica_od_videos');

    container.isotope({
	  // options...
	  itemSelector: '.od-video',
  	  percentPosition: true,
	  masonry: {
		columnWidth: 300
	  }
	});

});
