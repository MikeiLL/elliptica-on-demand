<div class="filters">

    	<div class="ui-group">
    
    		<div class="button-group" data-filter-group="level" id="difficulty_level">
        		<?php $count = count($difficulty_levels); ?>
        		<button style="float:left;" class="button is-checked" data-filter="*">Any Level</button>
        		<?php $all_terms = [];
        		if ( $count > 0 ){
        			foreach ( $difficulty_levels as $term ) {
        				$termname = strtolower($term->name);
        				$termname = str_replace(' ', '-', $termname);
        				echo '<button style="float:left;" class="button" value="' . $term->term_id .'" data-filter=".'.$termname.'">' . $term->name . '</button>';
        				$all_terms[$count] = $termname;
        				$count--;
        			}
        		echo '<button style="float:left;" class="button" data-filter=".'.implode('.', $all_terms).'">All Levels Welcome</button>';
        		} ?>
    		</div> <!-- button-group -->
    
    	</div> <!-- ui-group -->
    		
    		
    	<div class="ui-group">
    
    		<div class="button-group" data-filter-group="instructor" id="class_instructor">
    		<?php $count = count($instructors);?>
    		<button style="float:left;" class="button is-checked" data-filter="*">Any Instructor</button>
    		<?php if ( $count > 0 ){
    			foreach ( $instructors as $term ) {
    				$termname = strtolower($term->name);
    				$termname = str_replace(' ', '-', $termname);
    				echo '<button style="float:left;" class="button" value="' . $term->term_id .'" data-filter=".'.$termname.'">' . $term->name . '</button>';
    
    			}
    		}?>
    		</div> <!-- button-group -->
    
    	</div> <!-- ui-group -->
    
    	<div class="ui-group">
    
    		<div class="button-group" data-filter-group="music" id="music_style">
    		<?php $count = count($music_styles);?>
    		<button style="float:left;" class="button is-checked" data-filter="*">All Styles</button>
    		<?php if ( $count > 0 ){
    			foreach ( $music_styles as $term ) {
    				$termname = strtolower($term->name);
    				$termname = str_replace(' ', '-', $termname);
    				echo '<button style="float:left;" class="button" value="' . $term->term_id .'" data-filter=".'.$termname.'">' . $term->name . '</button>';
    
    			}
    		}?>
    		</div> <!-- button-group -->
    
    	</div> <!-- ui-group -->		
    		
    		
    	<div class="ui-group">
    
    		<div class="button-group" data-filter-group="length" id="class_length">
    		<?php $count = count($class_lengths);?>
    		<button style="float:left;" class="button is-checked" data-filter="*">Any Length</button>
    		<?php if ( $count > 0 ){
    			foreach ( $class_lengths as $term ) {
    				$termname = strtolower($term->name);
    				$termname = str_replace(' ', '-', $termname);
    				echo '<button style="float:left;" class="button" value="' . $term->term_id .'" data-filter=".'.$termname.'">' . $term->name . '</button>';
    
    			}
    		}?>
    		</div> <!-- button-group -->
    
    	</div> <!-- ui-group -->
	</div> <!-- // filters -->		
			
			
<div id="elliptica_od_videos">

<div class="on_demand_video_grid-sizer"></div>		

<?php 
		$modaal_id_count = 1;

		if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
		
		
		
			$isotope_filter_classes = "all od-video ";

			$post_id   = get_the_ID();

			// Difficulty levels
			$post_terms = wp_get_object_terms( $post_id, ['class_instructor', 'difficulty_level','music_style', 'class_length'] );

			if ( !empty($post_terms) ) {
				foreach ( $post_terms as $post_meta_item ) {
					$termname = strtolower($post_meta_item->name);
					$termname = str_replace(' ', '-', $termname);
					$isotope_filter_classes .= $termname .' ';
				}
			}
?>
	<a data-modaal-content-source="#modal-id-<?php echo $modaal_id_count;?>" href="#modal-id-<?php echo $modaal_id_count;?>" class="<?php echo $isotope_filter_classes;?> info-popup isotope_video_item">
			<?php if (has_post_thumbnail( $post_id ) ):
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'on_demand_video' );
			  	$custom_style = 'style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7)),url(' . $featured_image[0] .')"';
			else:
			$custom_style =  'style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7))"';
				endif; ?>

			<div class="od-video" data-modaal-type="inline" data-modaal-animation="fade" class="modaal" <?php echo $custom_style;?>>

    			<div class="od-video_info">
        			
        			<?php 
        			$instructor_and_type = '';
                    $class_instructors = get_the_terms( $post_id, 'class_instructor' );
        			if ( !empty($class_instructors) ) {
        				foreach ( $class_instructors as $class_instructor ) {
        				    $instructor_and_type .= $class_instructor->name . ' ';
        				}
        			}
                    ?>
        			<span aria-hidden="true"> · </span>
        			
        			<?php 
        			$class_type = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_class_type' );
        			if ( !empty($class_type) ) {
        				echo $class_type[0] . ' ';
        			}
        
        			$date_time = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_date' );
        			if ( !empty($date_time) ) {
        				echo "<br/>";
        				echo date_i18n('F j', $date_time[0]) . ' @ ' . date_i18n('g:i a', $date_time[0]);
        			} ?>
    			</div> <!-- //od-video_info -->

			</div> <!-- //od-video -->
	</a>
<?php
			$class_desc = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_desc' );
			if ( !empty($class_desc) ) {
				$description = $class_desc[0] . ' ';
			}

			$video_id = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_video_id' );
			if ( !empty($video_id) ) {
				$video_link = $video_id[0] . ' ';
			}

			/* Build the Modal Content */
			$modal_content = '<div id="modal-id-' . $modaal_id_count .'" style="display:none;">';

			/* Header */

			$difficulty_levels = [];
			$difficulty_levels_array = get_the_terms( $post_id, 'difficulty_level' );
			if ( !empty($difficulty_levels_array) ) {
				foreach ( $difficulty_levels_array as $k => $difficulty_level ) {
					$difficulty_levels[$k] = $difficulty_level->name . ' ';
				}
			}
			// Build modal class header background declaration
			$modal_header = '<div class="modal-class-details__header" ';
			if (has_post_thumbnail( $post_id ) ):
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'medium_large' );
			  	$modal_header .= 'style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7)),url(' . $featured_image[0] .')"';
			else:
				$modal_header .= 'style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7));"';
			endif;
			$modal_header .= '>'; // End modal class image background declaration

			$modal_header .= 	'	<div class="modal-class-details__header_content">';
			$modal_header .= 	'		<div>';
			//$modal_header .= 	'			<h5>' . $class_title .' </h5>';
			$modal_header .= 	'			<p>' . $instructor_and_type .' </p>';
			$modal_header .= 	'		</div>';
			$modal_header .= 	'		<div>';
			$modal_header .= 	'			<a class="modal_header_play_button" href="https://video.mindbody.io/studios/526618/videos/' . $video_link .'">Start</a>';
			// <svg viewBox="0 0 28 28" width="16" height="16"><g stroke="none" stroke-width="1" fill-rule="evenodd"><path d="M23.3870324,12.1022967 C25.1944355,13.1466985 25.1944355,14.8547015 23.3870324,15.8977033 L8.04720582,24.7541186 C6.23840269,25.7985204 4.76000013,24.9445189 4.76000013,22.8571153 L4.76000013,5.14288467 C4.76000013,3.05548105 6.23840269,2.20147957 8.04720582,3.24588138 L23.3870324,12.1022967 Z" fill="#ffffff"></path></g></svg>
			$modal_header .= 	'		</div>';
			$modal_header .= 	'	</div>';
			$modal_header .= 	'</div>';
			/* // End Header */


			$modal_content .= $modal_header;

			/* Modal Details Body */
			// (to wrap with padding below header, to avoid negative margin in header)
			$modal_content .= '	<div class="modal-class-details__body">';

			/* Intro */
			$modal_intro = 		'	<div class="modal-class-details__intro">';
			$modal_intro .= 	'		<div class="modal-class-details__intro__level>" ';
			$modal_intro .= 	'			<p><strong>Level</strong>: ' . implode(', ', $difficulty_levels) .' </p>';
			$modal_intro .= 	'		</div>';
			$modal_intro .= 	'		<div class="modal-class-details__intro__desc>" ';
			$modal_intro .= 	'			<p>' . $description .'</p>';
			$modal_intro .= 	'		</div>';
			$modal_intro .= 	'	</div>';

			$modal_content .= $modal_intro;

			/* // Intro */

			$class_plans = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_classplan' );
			$class_plans_only = $class_plans;
			/* Playlist */
			if ( !empty($class_plans) ) {
				$modal_content .= '	<div class="modal-class-details__playlist_section">';
				$modal_content .= '		<h2>Playlist</h2>';
				$modal_content .= '		<div class="modal-class-details__listwrap mcd__playlist_hideContent">';
				$modal_content .= '			<ol>';
				foreach ( $class_plans[0] as $class_segment ) {
					$modal_content .= '				<li class="modal-class-details__playlist_item"><img class="modal-class-details__playlist_img" src="' . $class_segment['song_artwork'] . '"/>';
					$modal_content .= '					<div class="modal-class-details__song_details">';
					$modal_content .= '						<strong>' . $class_segment['song_title'] . '</strong>';
					$modal_content .= '						<span>' . $class_segment['song_artists'] . '</span>';
					$modal_content .= '					</div>';
					$modal_content .= '			</li>';
				}
				$modal_content .= '			</ol>';
				$modal_content .= '		</div>';

				if (count($class_plans[0]) > 3) {
					$modal_content .= '		<div class="mcd_playlist__show-more">';
					$modal_content .= '			<a href="#">Show more</a>';
					$modal_content .= '		</div>';
				}
				$modal_content .= '	</div>';

			/* Class Plan */
				$modal_content .= '	<div class="modal-class-details__classplan_section">';
				$modal_content .= '		<h2>Class Plan</h2>';
				$modal_content .= '		<div class="modal-class-details__listwrap">';
				$modal_content .= '			<ol>';

				$minimized_class_plan = minimize_and_sum_class_plans($class_plans);
				foreach ( $minimized_class_plan as $class_segment ) {
					$modal_content .= '				<li class="modal-class-details__classplan_item">';
					$modal_content .= '					<div class="modal-class-details__segment_type">';
					$modal_content .= '						' . $class_segment['segment_type'];
					$modal_content .= '					</div>';
					$modal_content .= '					<div class="modal-class-details__segment_duration">';
					$modal_content .= '						' . $class_segment['segment_duration'] . ' min';
					$modal_content .= '					</div>';
					$modal_content .= '				</li>';
				}
				$modal_content .= '			</ol>';
				$modal_content .= '		</div>';
				$modal_content .= '	</div>';
			}


			/* End Modal Details Body */
			$modal_content .= '	</div>';

			/* End Modal Content */
			$modal_content .= '</div>';

			echo $modal_content;

			$modaal_id_count++;?>

		<?php endwhile; endif;?>
	</div>
			