<?php ?>

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

