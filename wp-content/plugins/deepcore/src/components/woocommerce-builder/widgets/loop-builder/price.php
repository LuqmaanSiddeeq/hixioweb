<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Price.
 *
 * @since 2.0.0
 */
class Price extends Deep_Loop_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-product-price';

	/**
	 * Retrieve the widget name.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'deep-woo-item-price';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Loop Product Price', 'deep' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'deep-widget deep-eicon-product-price';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'Deep_Product_Loop' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'General', 'deep' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'     => __( 'This widget displays the product price.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_price_box_styles();
		$this->register_price_wrapper_styles();
		$this->register_price_styles();
		$this->register_regular_price_styles();
	}

	/**
	 * Register Price Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_price_box_styles() {

		$group_id      = 'price_box_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Register Price Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_price_wrapper_styles() {

		$group_id      = 'price_wrapper_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Price Wrapper', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' p';
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = array();

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Register Sale Price Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_price_styles() {

		$group_id      = 'price_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Sale Price', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' p ins .amount,'
			. $base_selector . ' p > span.amount';
		$hover_selector = $base_selector . ' p ins:hover .amount,'
		. $base_selector . ' p > span.amount:hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'text_align' => false,
			),
			$group_id . 'hover_typography' => array(
				'text_align' => false,
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Register Regular Price Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_regular_price_styles() {

		$group_id      = 'regular_price_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Regular Price', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' p del .amount';
		$hover_selector = $base_selector . ' p del:hover .amount';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'text_align' => false,
			),
			$group_id . 'hover_typography' => array(
				'text_align' => false,
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$this->prepare_render();

		if ( $this->can_display_item_product() ) {

			Templates::widget( 'product-price', array() );
		}

		$this->reset_render();
	}
}
