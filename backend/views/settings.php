<div id="tabs-1" class="wrap">
			<?php
			$cmb = new_cmb2_box(
				array(
					'id'         => MMC_TEXTDOMAIN . '_options',
					'hookup'     => false,
					'show_on'    => array(
						'key'   => 'options-page',
						'value' => array( MMC_TEXTDOMAIN ),
					),
					'show_names' => true,
				)
			);
			$cmb->add_field(
				array(
					'name'    => __( 'Videos per paginated segment', MMC_TEXTDOMAIN ),
					'desc'    => __( 'Number if on demand classes to load at a time.', MMC_TEXTDOMAIN ),
					'id'      => 'videos_per_segment',
					'type'    => 'text',
					'default' => 20,
				)
			);


			cmb2_metabox_form( MMC_TEXTDOMAIN . '_options', MMC_TEXTDOMAIN . '-settings' );
			?>

		</div>
