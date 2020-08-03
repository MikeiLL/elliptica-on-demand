/*
 * Source: http://codepen.io/desandro/pen/GFbAs
 */
jQuery(document).ready(function( $ ) {
// Write in console log the PHP value passed in enqueue_js_vars in public/class-plugin-name.php
    console.log(mmc_js_vars.alert);
    //var container = $('#elliptica_od_videos');

    $('#elliptica_od_videos').isotope({
	  // options...
	  itemSelector: '.od-video',
	  masonry: {
		columnWidth: 200
	  }
	});

});
