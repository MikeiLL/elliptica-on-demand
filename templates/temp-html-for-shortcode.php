<div class="filters">
	<!-- Build out the Instructors FILTER -->
	<div class="ui-group">

		<div class="button-group" data-filter-group="level">
			<button style="float:left;" class="button is-checked" data-filter="*">Any Level</button>
			<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>
			<button style="float:left;" class="button" data-filter=".'.implode('.', $all_terms).'">All Levels Welcome</button>
		</div> <!-- button-group -->

	</div> <!-- ui-group -->

	<!-- Build out the Instructors FILTER -->

	<div class="ui-group">

		<div class="button-group" data-filter-group="instructor">

			<button style="float:left;" class="button is-checked" data-filter="*">Any Instructor</button>
			<!-- foreach ( $instructors as $term )  -->
			<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>

		</div> <!-- button-group -->

	</div> <!-- ui-group -->

	<!-- Build out the Music Styles FILTER -->
    <div class="ui-group">

		<div class="button-group" data-filter-group="music">

			<button style="float:left;" class="button is-checked" data-filter="*">All Styles</button>
			<!-- foreach ( $music_styles as $term )  -->
			<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>

		</div> <!-- button-group -->

	</div> <!-- ui-group -->

	<!-- Build out the Class Length FILTER -->
    <div class="ui-group">

		<div class="button-group" data-filter-group="length">
			<button style="float:left;" class="button is-checked" data-filter="*">Any Length</button>
			<!-- foreach ( $class_length as $term )  -->
			<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>
		</div> <!-- button-group -->

	</div> <!-- ui-group -->


</div> <!-- // filters -->

<!-- // filters -->
<div id="elliptica_od_videos">

	<div class="on_demand_video_grid-sizer"></div>
		<!-- Build out the On Demand Video Thumbnail -->
		<a data-modaal-content-source="#modal-id-' . $modaal_id_count .'"
			href="#modal-id- an-id-here"
			class=" info-popup isotope_video_item">
			<!-- Below add class which displays post thumbnail or placeholder -->
			<div class="od-video" data-modaal-type="inline" data-modaal-animation="fade" class="modaal HERE" >

				<div class="od-video_info">

					<h5>Class Title Here</h5> <!-- I think not using this maybe -->

					!-- instructor_and_type -->

					<!-- get_the_terms( $post_id, 'class_instructor' ); -->

					<span aria-hidden="true"> · </span> <!-- Spacer -->

					<!-- Add class type get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_class_type' ); -->

					<br/> <!-- line break -->

					<!-- $date_time = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_date' ); -->
					<!-- add the class date date_i18n('F j', $date_time[0]) . ' @ ' . date_i18n('g:i a', $date_time[0]); -->

				</div> <!-- //od-video_info -->';

			</div> <!-- //od-video -->';
		</a> <!-- end of On Demand Video thumbnail -->



			<!-- Build the Modal Content -->

			<!-- Hey Shafiq don't mind the extensive comments if they aren't helpful.
			$class_desc = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_desc' );
			In the Shortcode, currently, $prefix = '_elliptica_od_' You can find the rest
			of the metadata in `internals/PostTypes.php`. -->


			<!-- $video_id = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_video_id' ); -->

			<div id="modal-id-' . $modaal_id_count .'" style="display:none;">

			<!-- Header -->

			<!-- Build up $difficulty_levels_array from get_the_terms( $post_id, 'difficulty_level' ) -->

			<!-- Build modal class header background declaration to put image as CSS background -->
			<div class="modal-class-details__header">
			<!-- End modal class image background declaration -->

			<!-- Now put the data in the header -->
				<div class="modal-class-details__header_content">
					<div>
						<p>Instructor and Type Goes Here</p>
					</div>
					<div>
						<a class="modal_header_play_button" href="https://video.mindbody.io/studios/526618/videos/' . $video_link .'">Start</a>

			<!-- The following SVG was commented out, but leaving for the moment in case we want a play button: ▶︎ -->
			<!--
			<svg viewBox="0 0 28 28" width="16" height="16">
				<g stroke="none" stroke-width="1" fill-rule="evenodd">
					<path d="M23.3870324,12.1022967 C25.1944355,13.1466985 25.1944355,14.8547015 23.3870324,15.8977033 L8.04720582,24.7541186 C6.23840269,25.7985204 4.76000013,24.9445189 4.76000013,22.8571153 L4.76000013,5.14288467 C4.76000013,3.05548105 6.23840269,2.20147957 8.04720582,3.24588138 L23.3870324,12.1022967 Z" fill="#ffffff">
					</path>
				</g>
			</svg>
			-->
					</div>
				</div>
			</div>
			<!-- End Header -->




			<!-- Modal Details Body -->
			<!-- Wrap with padding below header, to avoid negative margin in header -->
			<div class="modal-class-details__body">

				<!-- Intro -->
				<div class="modal-class-details__intro">';
					<div class="modal-class-details__intro__level>"
						<p><strong>Level</strong>: Difficulty Levels Here </p>
					</div>
					<div class="modal-class-details__intro__desc">
						<p> description here </p>
					</div>
				</div>
				<!-- End of Intro -->

				<!-- Build up the Class Plan section -->
				<!-- Song Playlist -->
				<div class="modal-class-details__playlist_section">
					<h2>Playlist</h2>
					<div class="modal-class-details__listwrap mcd__playlist_hideContent">
						<ol>
						<!-- foreach ( $class_plans[0] as $class_segment ) -->
							<li class="modal-class-details__playlist_item">
								<img class="modal-class-details__playlist_img" src="' . $class_segment['song_artwork'] . '"/>
								<div class="modal-class-details__song_details">
									<strong>' . $class_segment['song_title'] . '</strong>
									<span>' . $class_segment['song_artists'] . '</span>
								</div>
							</li>
						</ol>
					</div>

				<!-- if (count($class_plans[0]) > 3) -->
					<div class="mcd_playlist__show-more">
						<a href="#">Show more</a>
					</div>

				</div>

				<!-- Class Plan -->
				<div class="modal-class-details__classplan_section">
					<h2>Class Plan</h2>
					<div class="modal-class-details__listwrap">
						<ol>

						<!-- foreach ( $minimized_class_plan as $class_segment ) -->
							<li class="modal-class-details__classplan_item">
								<div class="modal-class-details__segment_type">
									Segment Type Here
								</div>
								<div class="modal-class-details__segment_duration">
									Segment Duration (in minutes))
								</div>
							</li>

						</ol>
					</div>
				</div>

			<!-- End Modal Details Body -->
				</div>

			<!-- End Modal Content -->
			</div>

