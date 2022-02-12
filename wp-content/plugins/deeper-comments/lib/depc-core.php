<?php

/**
 * @link       http://webnus.biz
 * @since      1.0.0
 *
 * @package    Deeper Comments
 */

class Depc_Core {

	/**
	 * DEPC Instance
	 */
	private static $instance;

	/**
	 * The modules variable holds all modules of the DEPC.
	 */
	private static $modules = array();

	/**
	 * Main plugin path.
	 */
	private static $depc_path;

	/**
	 * Absolute plugin url.
	 */
	private static $depc_url;


	/**
	 * The unique identifier of this DEPC.
	 */
	const DEPC_ID = 'deeper-comment';

	/**
	 * The name identifier of this DEPC.
	 */
	const DEPC_NAME = 'Deeper Comment';


	/**
	 * The current version of the DEPC.
	 */
	const DEPC_VERSION = '1.0.1';

	/**
	 * The DEPC prefix to referenciate classes inside the DEPC
	 */
	const CLASS_PREFIX = 'Depc_';

	/**
	 * The DEPC prefix to referenciate files and prefixes inside the DEPC
	 */
	const DEPC_PREFIX = 'depc-';

	/**
	 * Provides access to a single instance of a module using the singleton pattern
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;

	}

	/**
	 * Define the core functionality of the DEPC.
	 */
	public function __construct() {

		self::$depc_path = plugin_dir_path( dirname( __FILE__ ) );
		self::$depc_url  = plugin_dir_url( dirname( __FILE__ ) );
		require_once( self::$depc_path . 'lib/' . self::DEPC_PREFIX . 'loader.php' );

		Depc_Loader::get_instance();
		Depc_Controller_Public::get_instance();
		Depc_Controller_Notification::get_instance();
		Depc_Controller_Follow_Conversion::get_instance();

		if(\Depc_Core::get_option( 'dc_show_online_status', 'Appearances' , 'off' ) == 'on' ) {
			Depc_Controller_Online_Users::get_instance();
		}

		Depc_Model_Public_Ajax::get_instance();
		Depc_Controller_Public_Comment::get_instance();
		Depc_Controller_Module_Login::get_instance();
		Depc_Controller_Module_Google::get_instance();

		Depc_Model_Public_Comment::get_instance();
		Depc_Model_Public_Comment_Edit::get_instance();
		Depc_Model_Public_Comment_Loop::get_instance();
		Depc_Model_Public_Comment_Vote::get_instance();
		Depc_Model_Public_Comment_Filter::get_instance();
		Depc_Controller_Public_Comment_Filter::get_instance();
		Depc_Controller_Public_Comment_MRA::get_instance();
		Depc_Model_Public_Comment_Word_Blacklist::get_instance();

		if(is_admin()){

			Depc_Controller_Admin_Enqueue::get_instance();
			Depc_Controller_Admin_Settings::get_instance();
			Depc_Controller_Admin_Notices::get_instance();
			Depc_Controller_Admin_Notification::get_instance();
			Depc_Model_Admin_Profile::get_instance();
			Depc_Controller_Admin_Statistics::get_instance();
		}

		require_once( self::$depc_path . 'lib/social-login/social-login-bws.php' );
		Depc_Actions_Filters::init_actions_filters();

	}

	/**
	 * Get plugin's absolute path.
	 */
	public static function get_depc_path() {

		return isset( self::$depc_path ) ? self::$depc_path : plugin_dir_path( dirname( __FILE__ ) );

	}

	/**
	 * Get plugin's absolute url.
	 */
	public static function get_depc_url() {

		return isset( self::$depc_url ) ? self::$depc_url : plugin_dir_url( dirname( __FILE__ ) );

	}

	public static function get_option( $option, $section, $default = '' ) {
		if ( empty( $option ) )
			return;

		$options = get_option( $section );
		if ( isset( $options[$option] ) ) {
			if(is_array($options[$option]) && count($options[$option]) === 1) {
				if(isset($options[$option]['on']) || isset($options[$option]['off'])) {
					$options[$option] = current($options[$option]);
				}
			}
			return $options[$option];
		}
		return $default;
	}

}