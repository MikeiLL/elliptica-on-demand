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
		loading_mode: null,
	};
	$(".loader_container").hide();
	// not required anymore ? var filters = {}; //store filters in an array
	$(".filters").on("click", ".button", function (event) {
		// For now, initialize pagination index to zero
		eod_video_state.paginated_segment_index = 1;
		var button = $(event.currentTarget);
		$(".loader_container").show();
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

		$("#elliptica_od_videos").html("");
		get_eod_videos_from_server_and_update_display();
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
		get_eod_videos_from_server_and_update_display();
	});

	/**
	 * Get Videos from server and update display.
	 */
	function get_eod_videos_from_server_and_update_display() {
		// Request list of post IDs from restful endpoint.
		let rest_params = eod_video_state.filter_parameters.concat([
			{
				name: "paginated_segment_index",
				value: eod_video_state.paginated_segment_index,
			},
		]);
		eod_enter_loading_mode();
		var fetch_url = eod_video_state.base_url + $.param(rest_params);
		console.log(fetch_url);
		eod_video_state.paginated_segment_index++;
		let display_load_more_button = false;
		fetch(fetch_url)
			.then((response) => {
				return response.json();
			})
			.then((videos) => {
				console.log("videos");
				console.log(videos);
				if (200 === videos.code) {
					// Maybe don't display the load more button.
					console.log("videos.data");
					console.log(videos.data);
					display_load_more_button =
						false ===
						eod_video_state.paginated_segment_index >= videos.max_num_pages;

					let modal_count =
						1 +
						eod_video_state.paginated_segment_index *
							eod_video_state.paginated_segment_size;

					for (var i = 0; i < videos.data.length; i++) {
						var od_video_element = new Od_Video_Elem(
							modal_count,
							videos.data[i]
						);

						var video_container = $(".video_item_template").clone();
						video_container.attr(
							"data-modaal-content-source",
							"#modal-id-" + modal_count
						);
						video_container.attr("href", "#modal-id-" + modal_count);
						video_container.attr("data-post-title", videos.data[i].post_title);
						video_container.removeClass("video_item_template");
						let video_container_background =
							"linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7))";
						if ("" !== videos.data[i].featured_image) {
							video_container_background +=
								", url(" + videos.data[i].featured_image + ")";
						}
						video_container
							.find(".od-video_info")
							.append(
								videos.data[i].class_instructor +
									'<span aria-hidden="true"> · </span>' +
									videos.data[i].class_type +
									"<br>" +
									od_video_element.class_date
							);
						video_container
							.find(".od-video")
							.css("background", video_container_background);

						/* Modal Container */
						var modal_container = $(".video_item_modal_template").clone();

						let difficulty_levels_string = build_difficulty_levels_string(
							videos.data[i].difficulty_levels
						);
						modal_container
							.find(".modal-class-details__intro__level")
							.html(difficulty_levels_string);
						modal_container
							.find(".modal-class-details__intro__desc")
							.html("<p>" + videos.data[i].class_description + "</p>");
						modal_container
							.find(".instructor_and_type")
							.append(
								videos.data[i].class_instructor +
									'<span aria-hidden="true"> · </span>' +
									videos.data[i].class_type +
									"<br>" +
									od_video_element.class_date
							);

						modal_container
							.find(".modal-class-details__header")
							.css("background", video_container_background);
						modal_container
							.find("modal_header_play_button")
							.attr(
								"href",
								"https://video.mindbody.io/studios/526618/videos/" +
									videos.data[i].video_id
							);

						let playlist = videos.data[i].playlist;
						let playlist_holder = $("<ol>");
						playlist_holder.addClass("modal-class-details__song_holder");
						for (var j = 0; j < playlist.length; j++) {
							let playlist_item = $("<li>");
							let song_details = $("<div>");
							song_details.addClass("modal-class-details__song_details");
							let artwork = $("<img>");
							let title = $("<strong>");
							let artist = $("<span>");
							playlist_item.addClass("modal-class-details__playlist_item");
							artwork.attr("src", playlist[j].song_artwork);
							playlist_item.append(artwork);
							title.html(playlist[j].song_title);
							song_details.append(title);
							artist.html(playlist[j].song_artists);
							song_details.append(artist);
							playlist_item.append(song_details);
							playlist_holder.append(playlist_item);
						}

						let classplan = videos.data[i].class_plan;
						let classplan_holder = $("<ol>");
						classplan_holder.addClass("modal-class-details__classplan_holder");
						for (var k = 0; k < classplan.length; k++) {
							let classplan_item = $("<li>");
							classplan_item.addClass("modal-class-details__classplan_item");
							let segment_type = $("<div>");
							segment_type.addClass("modal-class-details__segment_type");
							let segment_duration = $("<div>");
							segment_duration.addClass(
								"modal-class-details__segment_duration"
							);
							segment_type.html(classplan[k].segment_type);
							classplan_item.append(segment_type);
							segment_duration.html(classplan[k].segment_duration + " min");
							classplan_item.append(segment_duration);
							classplan_holder.append(classplan_item);
						}

						modal_container.find(".class_playlist").append(playlist_holder);
						modal_container.find(".class_classplan").append(classplan_holder);

						modal_container.removeClass("video_item_modal_template");
						video_container.show();
						$(modal_container).attr("id", "modal-id-" + modal_count);
						$("#elliptica_od_videos").append(video_container);
						$("#elliptica_od_videos").append(
							"<!-- /* Build the Modal Content */ -->"
						);
						$("#elliptica_od_videos").append(modal_container);
						modal_count++;
					}

					$(".info-popup").modaal();
				} else {
					$("#elliptica_od_videos").html("<h1>no videos found</h1>");
				}
				eod_exit_loading_mode(display_load_more_button);
			});
	}

	/**
	 * Build Difficulty Levels String
	 */
	function build_difficulty_levels_string(difficulty_levels) {
		let names = [];
		for (let i = 0; i < difficulty_levels.length; i++) {
			names.push(difficulty_levels[i].name);
		}
		return "<p><strong>Level</strong>: " + names.join(", ") + "</p>";
	}

	/**
	 * Enter Loading Mode
	 *
	 * @returns null
	 */
	function eod_enter_loading_mode() {
		$("#eod_load_more").hide();
		$(".loader_container").show();
	}

	/**
	 * Enter Loading Mode
	 *
	 * @param display_load_more bool
	 * @returns null
	 */
	function eod_exit_loading_mode(display_load_more) {
		display_load_more =
			typeof display_load_more !== "undefined" ? display_load_more : true;
		$(".loader_container").hide();
		if (true === display_load_more) {
			$("#eod_load_more").show();
		}
		// reinit show more button
		eod_video_show_more();
	}
	/**
	 * Build OD Video Container
	 *
	 * @returns html for single on-demand video details container and modal.
	 */
	function build_od_video_container(modal_id, video_data_element) {
		const od_video_container = $(".video_item_template");
		const od_video_modal_container = $(".video_item_modal_template");

		return od_video_container.html();
	}
});
