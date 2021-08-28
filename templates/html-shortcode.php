<div class="filters">

	<div class="ui-group">

		<div class="button-group" data-filter-group="level"
			id="difficulty_level">
				<?php $count = count( $difficulty_levels ); ?>
				<button style="float: left;" class="button is-checked"
				data-filter="*">Any Level</button>
				<?php

				$all_terms = array();
				if ( $count > 0 ) {
					foreach ( $difficulty_levels as $term ) {
						$termname = strtolower( $term->name );
						$termname = str_replace( ' ', '-', $termname );
						echo '<button style="float:left;" class="button" value="' . $term->term_id . '" data-filter=".' . $termname . '">' . $term->name . '</button>';
						$all_terms[ $count ] = $termname;
						$count --;
					}

					echo '<button style="float:left;" class="button" data-filter=".' . implode( '.', $all_terms ) . '">All Levels Welcome</button>';
				}
				?>
			</div>
		<!-- button-group -->

	</div>
	<!-- ui-group -->


	<div class="ui-group">

		<div class="button-group" data-filter-group="instructor"
			id="class_instructor">
			<?php $count = count( $instructors ); ?>
			<button style="float: left;" class="button is-checked"
				data-filter="*">Any Instructor</button>
			<?php

			if ( $count > 0 ) {
				foreach ( $instructors as $term ) {
					$termname = strtolower( $term->name );
					$termname = str_replace( ' ', '-', $termname );
					echo '<button style="float:left;" class="button" value="' . $term->term_id . '" data-filter=".' . $termname . '">' . $term->name . '</button>';
				}
			}
			?>
			</div>
		<!-- button-group -->

	</div>
	<!-- ui-group -->

	<div class="ui-group">

		<div class="button-group" data-filter-group="music" id="music_style">
			<?php $count = count( $music_styles ); ?>
			<button style="float: left;" class="button is-checked"
				data-filter="*">All Styles</button>
			<?php

			if ( $count > 0 ) {
				foreach ( $music_styles as $term ) {
					$termname = strtolower( $term->name );
					$termname = str_replace( ' ', '-', $termname );
					echo '<button style="float:left;" class="button" value="' . $term->term_id . '" data-filter=".' . $termname . '">' . $term->name . '</button>';
				}
			}
			?>
			</div>
		<!-- button-group -->

	</div>
	<!-- ui-group -->


	<div class="ui-group">

		<div class="button-group" data-filter-group="length" id="class_length">
			<?php $count = count( $class_lengths ); ?>
			<button style="float: left;" class="button is-checked"
				data-filter="*">Any Length</button>
			<?php

			if ( $count > 0 ) {
				foreach ( $class_lengths as $term ) {
					$termname = strtolower( $term->name );
					$termname = str_replace( ' ', '-', $termname );
					echo '<button style="float:left;" class="button" value="' . $term->term_id . '" data-filter=".' . $termname . '">' . $term->name . '</button>';
				}
			}
			?>
			</div>
		<!-- button-group -->

	</div>
	<!-- ui-group -->
</div>
<!-- // filters -->


<div id="elliptica_od_videos">

	<div class="on_demand_video_grid-sizer"></div>		
		<?php
		eod_get_template(
			'videos_loop.php',
			array(
				'query'  => $query,
				'prefix' => $prefix,
			)
		);
		?>
	</div>
