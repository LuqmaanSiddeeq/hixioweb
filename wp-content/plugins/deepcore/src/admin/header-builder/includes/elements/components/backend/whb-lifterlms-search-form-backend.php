<!-- modal text edit -->
<div class="whb-modal-wrap whb-modal-edit" data-element-target="lifterlms-search-form">

	<div class="whb-modal-header">
		<h4><?php esc_html_e( 'Lifterlms Search', 'deep' ); ?></h4>
		<i class="ti-close"></i>
	</div>

	<div class="whb-modal-contents-wrap">
		<div class="whb-modal-contents w-row">

			<ul class="whb-tabs-list whb-element-groups wp-clearfix">
				<li class="whb-tab w-active">
					<a href="#general">
						<span><?php esc_html_e( 'General', 'deep' ); ?></span>
					</a>
				</li>
				<li class="whb-tab">
					<a href="#styling">
						<span><?php esc_html_e( 'Styling', 'deep' ); ?></span>
					</a>
				</li>
				<li class="whb-tab">
					<a href="#classID">
						<span><?php esc_html_e( 'Class & ID', 'deep' ); ?></span>
					</a>
				</li>
			</ul> <!-- end .whb-tabs-list -->

			<!-- general -->
			<div class="whb-tab-panel whb-group-panel" data-id="#general">

				<?php
					whb_textfield(
						array(
							'title'   => esc_html__( 'Placeholder', 'deep' ),
							'id'      => 'text',
							'default' => 'Search For The Courses, Software or Skills You Want to Learn...',
						)
					);

					whb_select(
						array(
							'title'   => esc_html__( 'Button Type', 'deep' ),
							'id'      => 'search_button',
							'default' => 'text',
							'options' => array(
								'text' => esc_html__( 'Text', 'deep' ),
								'icon' => esc_html__( 'Icon', 'deep' ),
							),
						)
					);
					?>

			</div> <!-- end general -->

			<!-- styling -->
			<div class="whb-tab-panel whb-group-panel" data-id="#styling">

				<?php
					whb_styling_tab(
						array(
							'Button' => array(
								array( 'property' => 'color' ),
								array( 'property' => 'color_hover' ),
								array( 'property' => 'font_size' ),
								array( 'property' => 'line_height' ),
								array( 'property' => 'margin' ),
								array( 'property' => 'padding' ),
								array( 'property' => 'border' ),
							),
							'Input'  => array(
								array( 'property' => 'width' ),
								array( 'property' => 'height' ),
								array( 'property' => 'background_color' ),
								array( 'property' => 'background_color_hover' ),
								array( 'property' => 'margin' ),
								array( 'property' => 'padding' ),
								array( 'property' => 'border' ),
								array( 'property' => 'border_radius' ),
							),
							'Box'    => array(
								array( 'property' => 'width' ),
								array( 'property' => 'height' ),
								array( 'property' => 'background_color' ),
								array( 'property' => 'background_color_hover' ),
								array( 'property' => 'margin' ),
								array( 'property' => 'padding' ),
								array( 'property' => 'border' ),
								array( 'property' => 'border_radius' ),
							),
						)
					);
					?>

			</div> <!-- end #styling -->

			<!-- classID -->
			<div class="whb-tab-panel whb-group-panel" data-id="#classID">

				<?php

					whb_textfield(
						array(
							'title' => esc_html__( 'Extra class', 'deep' ),
							'id'    => 'extra_class',
						)
					);

					?>

			</div> <!-- end #classID -->

		</div>
	</div> <!-- end whb-modal-contents-wrap -->

	<div class="whb-modal-footer">
		<input type="button" class="whb_close button" value="<?php esc_html_e( 'Close', 'deep' ); ?>">
		<input type="button" class="whb_save button button-primary" value="<?php esc_html_e( 'Save Changes', 'deep' ); ?>">
	</div>

</div> <!-- end whb-elements -->
