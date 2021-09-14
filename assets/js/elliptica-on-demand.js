/*
 * Source: http://codepen.io/desandro/pen/GFbAs
 */
/* jshint browser: true */
/* global mmc_js_vars */
/* global Od_Video_Elem */
jQuery(($) => {
	// Object to hold state of filter and video dislay data
	var eod_video_state = {
		paginated_segment_index: 1,
		paginated_segment_size: mmc_js_vars.paginated_segment_size,
		filter_parameters: [],
		base_url: window.location.origin + "/wp-json/eod/v1/posts?",
	};

	eod_set_isotope();

	// not required anymore ? var filters = {}; //store filters in an array
	$(".filters").on("click", ".button", function (event) {
		// For now, initialize pagination index to zero
		eod_video_state.paginated_segment_index = 0;
		var button = $(event.currentTarget);

		// get group key
		var buttonGroup = button.parents(".button-group");
		var base_filter = buttonGroup.attr("id");

		// Clear rest params
		eod_video_state.filter_parameters = [];

		$(".button-group").each(function () {
			//other filters
			if ($(this).attr("id") === base_filter) {
				eod_video_state.filter_parameters.push({
					name: $(this).attr("id"),
					value: button.val(),
				});
			} else {
				var current_button = "";
				$("#" + $(this).attr("id") + " > button").each(function () {
					if ($(this).hasClass("is-checked")) {
						current_button = $(this).val();
					}
				});
				eod_video_state.filter_parameters.push({
					name: $(this).attr("id"),
					value: current_button,
				});
			}
		});
		let rest_params = eod_video_state.filter_parameters.concat([
			{
				name: "paginated_segment_index",
				value: eod_video_state.paginated_segment_index,
			},
		]);
		console.log(rest_params);
		var fetch_url = eod_video_state.base_url + $.param(rest_params);

		fetch(fetch_url)
			.then((response) => {
				return response.json();
			})
			.then((videos) => {
				if (200 === videos.code) {
					var videos_data = videos.result;

					$.ajax({
						url: mmc_js_vars.ajax_url,
						type: "GET",
						aSync: false,
						dataType: "html",
						data: {
							data: videos_data,
							paginated_segment_index: parseInt(
								eod_video_state.paginated_segment_index
							),
							action: "get_videos_ajax_loop",
						},
						success: function (response) {
							$("#elliptica_od_videos").html(response);
							eod_video_state.paginated_segment_index++;
							$(".info-popup").modaal();
							eod_video_show_more();
							eod_set_isotope();
						},
						error: function (e) {
							console.log(e);
						},
					});
				} else {
					$("#elliptica_od_videos").html(
						"<div>" + mmc_js_vars.no_results_message + "</div>"
					);
				}
			});
	});

	// change is-checked class on buttons
	$(".button-group").each(function (i, buttonGroup) {
		var $buttonGroup = $(buttonGroup);
		$buttonGroup.on("click", "button", function (event) {
			$buttonGroup.find(".is-checked").removeClass("is-checked");
			var button = $(event.currentTarget);
			button.addClass("is-checked");
		});
	});

	// flatten object by concatting values
	function concatValues(obj) {
		var value = "";
		for (var prop in obj) {
			value += obj[prop];
		}
		return value;
	}

	$(".info-popup").modaal();
	eod_video_show_more();

	function eod_video_show_more() {
		$(".mcd_playlist__show-more > a").on("click", function () {
			var self = $(this);
			var content = self.parent().prev(".modal-class-details__listwrap");
			var linkText = self.text().toUpperCase();

			if (linkText === "SHOW MORE") {
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
	}

	$("#eod_load_more").on("click", function (e) {
		e.preventDefault();
		// Request list of post IDs from restful endpoint.
		let rest_params = eod_video_state.filter_parameters.concat([
			{
				name: "paginated_segment_index",
				value: eod_video_state.paginated_segment_index,
			},
		]);
		var fetch_url = eod_video_state.base_url + $.param(rest_params);
		eod_video_state.paginated_segment_index++;
		console.log(fetch_url);
		fetch(fetch_url)
			.then((response) => {
				return response.json();
			})
			.then((videos) => {
				if (200 === videos.code) {
					console.log(videos.data);
					let modal_count =
						1 +
						eod_video_state.paginated_segment_index *
							eod_video_state.paginated_segment_size;
					console.log("modal count: " + modal_count);
					for (var i = 0; i <= videos.data.length; i++) {
						var template = new Od_Video_Elem(modal_count, videos.data[i]);
						modal_count++;
						console.log(modal_count);
						console.log(template);
					}
					// Make ajax call to retrieve html for videos
					/* $.ajax({
						url: mmc_js_vars.ajax_url,
						type: "GET",
						aSync: false,
						dataType: "html",
						data: {
							data: videos_data,
							paginated_segment_index: parseInt(
								eod_video_state.paginated_segment_index
							),
							action: "get_videos_ajax_loop",
						},
						success: function (response) {
							$("#elliptica_od_videos").append(response);
							eod_video_state.paginated_segment_index++;
							$(".info-popup").modaal();
							eod_video_show_more();
							eod_set_isotope();
						},
						error: function (e) {
							console.log(e);
						},
					}); */
				} else {
					//$("#elliptica_od_videos").html(
					//	"<div>" + mmc_js_vars.no_results_message + "</div>"
					//);
				}
			});
	});

	function eod_set_isotope() {
		var iso_grid = $("#elliptica_od_videos").isotope({
			itemSelector: ".isotope_video_item",
			percentPosition: true,
			masonry: {
				columnWidth: ".on_demand_video_grid-sizer",
			},
		});
	}
});
