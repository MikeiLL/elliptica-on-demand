
	<div class="on_demand_video_grid-sizer"></div>		

<?php
$modaal_id_count = 1;
if ($query->have_posts()) :
    while ($query->have_posts()) :
        $query->the_post();

        $isotope_filter_classes = "all od-video ";

        $post_id = get_the_ID();

        // Difficulty levels
        $post_terms = wp_get_object_terms($post_id, [
            'class_instructor',
            'difficulty_level',
            'music_style',
            'class_length'
        ]);

        if (! empty($post_terms)) {
            foreach ($post_terms as $post_meta_item) {
                $termname = strtolower($post_meta_item->name);
                $termname = str_replace(' ', '-', $termname);
                $isotope_filter_classes .= $termname . ' ';
            }
        }
        ?>
	<a
		data-modaal-content-source="#modal-id-<?php echo $modaal_id_count;?>"
		href="#modal-id-<?php echo $modaal_id_count;?>"
		class="<?php echo $isotope_filter_classes;?> info-popup isotope_video_item">
			<?php

if (has_post_thumbnail($post_id)) :
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'on_demand_video');
            $custom_style = 'style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7)),url(' . $featured_image[0] . ')"';
        else :
            $custom_style = 'style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7))"';
        endif;
        ?>

			<div class="od-video" data-modaal-type="inline"
			data-modaal-animation="fade" class="modaal"
			<?php echo $custom_style;?>>

			<div class="od-video_info">
        			
        			<?php
        $instructor_and_type = '';
        $class_instructors = get_the_terms($post_id, 'class_instructor');
        if (! empty($class_instructors)) {
            foreach ($class_instructors as $class_instructor) {
                $instructor_and_type .= $class_instructor->name . ' ';
            }
        }
        $instructor_and_type .= '<span aria-hidden="true"> · </span>';

        $class_type = get_post_meta($post_id, $prefix . MMC_TEXTDOMAIN . '_class_type');
        if (! empty($class_type)) {
            $instructor_and_type .= $class_type[0] . ' ';
        }

        $date_time = get_post_meta($post_id, $prefix . MMC_TEXTDOMAIN . '_date');
        if (! empty($date_time)) {
            $instructor_and_type .= "<br/>";
            $instructor_and_type .= date_i18n('F j', $date_time[0]) . ' @ ' . date_i18n('g:i a', $date_time[0]);
        }
        
        echo $instructor_and_type;
        ?>
    			</div>
			<!-- //od-video_info -->

		</div> <!-- //od-video -->
	</a>
<?php
        $class_desc = get_post_meta($post_id, $prefix . MMC_TEXTDOMAIN . '_desc');
        if (! empty($class_desc)) {
            $description = $class_desc[0] . ' ';
        }

        $video_id = get_post_meta($post_id, $prefix . MMC_TEXTDOMAIN . '_video_id');
        if (! empty($video_id)) {
            $video_link = $video_id[0] . ' ';
        }
        ?>
			<!-- /* Build the Modal Content */ -->
	<div id="modal-id-<?php esc_attr_e($modaal_id_count) ?>"
		style="display: none;">
<?php
        /* Header */

        $difficulty_levels = [];
        $difficulty_levels_array = get_the_terms($post_id, 'difficulty_level');
        if (! empty($difficulty_levels_array)) {
            foreach ($difficulty_levels_array as $k => $difficulty_level) {
                $difficulty_levels[$k] = $difficulty_level->name . ' ';
            }
        }

        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'medium_large');
        $header_attr = $featured_image[0] ? 'style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7)),url(' . $featured_image[0] . ')"' : 'style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7));"';

        ?>
        <!-- Build modal class header background declaration -->
		<div class="modal-class-details__header" <?php echo $header_attr; ?>>



			<div class="modal-class-details__header_content">
				<div>
					<!-- <h5><?php //echo $class_title;?></h5> -->
					<p><?php echo $instructor_and_type; ?></p>
				</div>
				<div>
					<a class="modal_header_play_button"
						href="https://video.mindbody.io/studios/526618/videos/<?php echo $video_link; ?>"><?php esc_html_e('Start');?></a>
					<!-- <svg viewBox="0 0 28 28" width="16" height="16"><g stroke="none" stroke-width="1" fill-rule="evenodd"><path d="M23.3870324,12.1022967 C25.1944355,13.1466985 25.1944355,14.8547015 23.3870324,15.8977033 L8.04720582,24.7541186 C6.23840269,25.7985204 4.76000013,24.9445189 4.76000013,22.8571153 L4.76000013,5.14288467 C4.76000013,3.05548105 6.23840269,2.20147957 8.04720582,3.24588138 L23.3870324,12.1022967 Z" fill="#ffffff"></path></g></svg> -->
				</div>
			</div>
		</div>

		<div class="modal-class-details__body">

			<div class="modal-class-details__intro">
				<div class="modal-class-details__intro__level">
					<p>
						<strong>Level</strong>: <?php echo implode(', ', $difficulty_levels); ?></p>
				</div>
				<div class="modal-class-details__intro__desc">
					<p><?php echo $description; ?></p>

				</div>
			</div>

<?php
        /* // Intro */

        $class_plans = get_post_meta($post_id, $prefix . MMC_TEXTDOMAIN . '_classplan');
        $class_plans_only = $class_plans;

        /* Playlist */
        if (! empty($class_plans)) {
            ?>
			<div class="modal-class-details__playlist_section">
				<h2>Playlist</h2>
				<div class="modal-class-details__listwrap mcd__playlist_hideContent">
					<ol>

        				<?php foreach ( $class_plans[0] as $class_segment ) { ?>
        					<li class="modal-class-details__playlist_item"><img
							class="modal-class-details__playlist_img"
							src="<?php echo $class_segment['song_artwork']; ?>" />
							<div class="modal-class-details__song_details">
								<strong><?php echo $class_segment['song_title']; ?></strong> <span><?php echo $class_segment['song_artists']; ?></span>
							</div></li>
        					
        				<?php } ?>
				
						</ol>
				</div>

    				<?php if (count($class_plans[0]) > 3) { ?>
    					<div class="mcd_playlist__show-more">
					<a href="#">Show more</a>
				</div>
    				<?php } ?>
    				</div>

			<div class="modal-class-details__classplan_section">
				<h2>Class Plan</h2>
				<div class="modal-class-details__listwrap">
					<ol>

				<?php

$minimized_class_plan = minimize_and_sum_class_plans($class_plans);
            foreach ($minimized_class_plan as $class_segment) {
                ?>
					<li class="modal-class-details__classplan_item">
							<div class="modal-class-details__segment_type">
							<?php echo $class_segment['segment_type']; ?>
						</div>
							<div class="modal-class-details__segment_duration">
							<?php echo $class_segment['segment_duration'] . ' min'; ?>
						</div>
						</li>
				<?php } ?>
				</ol>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
<?php $modaal_id_count++; ?>

		<?php endwhile; endif;?>