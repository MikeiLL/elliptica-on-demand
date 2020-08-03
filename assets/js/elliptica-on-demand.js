/*
 * Source: http://codepen.io/desandro/pen/GFbAs
 */
jQuery(document).ready(function( $ ) {
// Write in console log the PHP value passed in enqueue_js_vars in public/class-plugin-name.php
    console.log(pn_js_vars.alert);
    var container = $('#instructors'),
    		checkboxes = $('#checkboxes input'),
    		filters = $('#filters a'),
    		filter_buttons = $('#filters li');

    // create a clone that will be used for measuring container width
    var containerProxy = container.clone().empty().css({ visibility: 'hidden' });

    container.after( containerProxy );

    // get the first item to use for measuring columnWidth
    var item = container.find('.instructor-item').eq(0);

    container.imagesLoaded(function(){
        $(window).smartresize( function() {

            // calculate columnWidth
            var colWidth = Math.floor( containerProxy.width() / 3 ); // Change this number to your desired amount of columns

            // set width of container based on columnWidth
            container.css({
                width: colWidth * 3 // Change this number to your desired amount of columns
            })
            .isotope({

                // disable automatic resizing when window is resized
                resizable: false,

                // set columnWidth option for masonry
                masonry: {
                    columnWidth: colWidth
                }
            });

        // trigger smartresize for first time
        }).smartresize();
    });

 		var filter_content = function(){
 			// Default filter setting
 			var filterSelector = '';
 			var self = $(this);
 			if(self.is('a') === true){
 				// Filter button was clicked
 				filterSelector = self.attr('data-filter');
 				$('#filters > li').removeClass('active');
 				self.parent().addClass('active');
 			} else {
 				// Assume it's one of the checkboxes
 				// Get data-filter val from first active filter box
 				var first_active = filter_buttons.first('active');
 				filterSelector = first_active.find('a').attr('data-filter');
 			}

			// map input values to an array
			var exclusives = [filterSelector];
			// inclusive filters from checkboxes
			checkboxes.each( function( i, elem ) {
				// if checkbox, use value if checked
				if ( elem.checked ) {
					exclusives.push( elem.value );
				}
			});
			var filterValue;
			filterValue = exclusives.join('');

			// $('#selected').text( filterValue );
			container.isotope({ filter: filterValue, animationEngine : "css" });
			return false;
    }
    // filter items when filter link is clicked
    filters.click(filter_content);
    checkboxes.change(filter_content);

});
