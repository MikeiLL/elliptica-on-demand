<?php
/**
 * On Demand Video Grid Item Template with Moday DOM element as well.
 */
?>
<a style="display: none;" class="info-popup isotope_video_item video_item_template">
  <div class="od-video">
	<div class="od-video_info"></div>
	<!-- //od-video_info -->
  </div>
  <!-- //od-video -->
</a>

<!-- Modal Window -->
<!-- /* Build the Modal Content */ -->
<div id="modal-id-goes-here"
		style="display: none;" class="video_item_modal_template">
		<!-- Build modal class header background declaration -->
		<div class="modal-class-details__header"> <!-- some styling needs to be applied to details__header, needs background image. -->

			<div class="modal-class-details__header_content">
				<div>
					<!-- <h5 style="class-title"></h5> -->
					<p class="instructor_and_type"></p>
				</div>
				<div>
					<a class="modal_header_play_button"
						href="https://video.mindbody.io/studios/526618/videos/">Start</a>
					<!-- <svg viewBox="0 0 28 28" width="16" height="16"><g stroke="none" stroke-width="1" fill-rule="evenodd"><path d="M23.3870324,12.1022967 C25.1944355,13.1466985 25.1944355,14.8547015 23.3870324,15.8977033 L8.04720582,24.7541186 C6.23840269,25.7985204 4.76000013,24.9445189 4.76000013,22.8571153 L4.76000013,5.14288467 C4.76000013,3.05548105 6.23840269,2.20147957 8.04720582,3.24588138 L23.3870324,12.1022967 Z" fill="#ffffff"></path></g></svg> -->
				</div>
			</div>
		</div>

		<div class="modal-class-details__body">

			<div class="modal-class-details__intro">
				<div class="modal-class-details__intro__level"></div>
				<div class="modal-class-details__intro__desc"></div>
			</div>
			<div class="modal-class-details__playlist_section">
				<h2>Playlist</h2>
				<div class="modal-class-details__listwrap mcd__playlist_hideContent class_playlist">
					<!--<ol>
							<li style="display:none" class="modal-class-details__playlist_item playlist_item"><img
							class="modal-class-details__playlist_img"
							src="" />
							<div class="modal-class-details__song_details">
								<strong></strong> <span></span>
							</div></li>

						</ol>-->
				</div>

				<div class="mcd_playlist__show-more">
					<a href="#">Show more</a>
				</div>
			</div>

			<div class="modal-class-details__classplan_section class_classplan">
				<h2>Class Plan</h2>
				<div class="modal-class-details__listwrap">
					<!-- <ol>
						<li class="modal-class-details__classplan_item">
							<div class="modal-class-details__segment_type"></div>
							<div class="modal-class-details__segment_duration"></div>
						</li>
					</ol> -->
				</div>
			</div>

		</div>
	</div>
