class Od_Video_Elem {
	constructor(modaal_id, class_instructor) {
		this.modaal_id = modaal_id;
		this.class_instructor = class_instructor;
	}
}
/**
 * 			'class_instructor' => get_the_terms( $post_id, 'class_instructor' ),
			'class_type' => get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_class_type' ),
			'difficulty_level' => get_the_terms( $post_id, 'difficulty_level' ),
			'class_date' => date_i18n( 'F j', $date_time[0] ) . ' @ ' . date_i18n( 'g:i a', $date_time[0] ),
			'class_description' => get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_desc' ),
			'video_id' => get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_video_id' ),
			'featured_image' => isset($featured_image[0]) ? $featured_image[0] : '',
			'class_plan' => minimize_and_sum_class_plans( $class_plan )
 */
