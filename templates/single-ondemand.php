<?php get_header(); ?>
<?php

		$return = "<h1>" . get_the_title() . "</h1>";

		$prefix   = '_elliptica_od_';

		$post_id   = get_the_ID();

		$music_style = get_the_terms( $post_id, 'music_style' );
		if ( !empty($music_style) ) {
			$return .= "<strong>Music</strong>: ";
			foreach ( $music_style as $music_style ) {
				$return .= $music_style->slug .' ';
			}
		}

		$fitness_levels = get_the_terms( $post_id, 'fitness_level' );
		if ( !empty($fitness_levels) ) {
			$return .= "<strong>Class Type</strong>: ";
			foreach ( $fitness_levels as $fitness_level ) {
				$return .= $fitness_level->slug .' ';
			}
		}

		$class_instructors = get_the_terms( $post_id, 'class_instructor' );
		if ( !empty($class_instructors) ) {
			$return .= "<strong>Instructor</strong>: ";
			foreach ( $class_instructors as $class_instructor ) {
				$return .= $class_instructor->slug .' ';
			}
		}

		$class_plans = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_classplan' );
		if ( !empty($class_plans) ) {
			$return .= "<h4>Playlist</h4>";
			$return .= "<table>";
			foreach ( $class_plans as $class_plan ) {
				foreach ( $class_plan as $class_segment ) {
					$return .= '<tr>';
					$return .= '<td><img src="' . $class_segment['song_artwork'] . '" height="100" width="100" /></td>';
					$return .= '<td>' . $class_segment['song_title'] . '</td>';
					$return .= '<td>' . $class_segment['song_artists'] . '</td>';
					$return .= '</tr>';
				}
			}
			$return .= "</table>";
			$return .= "<h4>Class Plan</h4>";
			$return .= "<table>";
			foreach ( $class_plans as $class_plan ) {
				foreach ( $class_plan as $class_segment ) {
					$return .= '<tr>';
					$return .= '<td>' . $class_segment['segment_type'] . '</td>';
					$return .= '<td>' . $class_segment['segment_duration'] . ' minutes</td>';
					$return .= '</tr>';
				}
			}
			$return .= "</table>";
		}

		echo $return;
?>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
