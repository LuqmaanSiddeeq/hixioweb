<?php

/**
 * @link       http://webnus.biz
 * @since      1.0.0
 *
 * @package    Deeper Comments
 */

class Depc_Controller_Admin_Notification extends Depc_Controller_Public_Comment{

    private static $instances = array();

	/**
	 * Provides access to a single instance of a module using the singleton pattern
	 *
	 * @since    1.0.0
	 */
	public static function get_instance() {
		$classname = get_called_class();

		if ( ! isset( self::$instances[ $classname ] ) ) {
			self::$instances[ $classname ] = new $classname();
		}
		return self::$instances[ $classname ];

	}

	/**
	 * Constructor
	 *
	 * @since    1.0.0
	 */
	protected function __construct() {
		$this->set_actions();
    }

    /**
	 * Set WP Hooks (Actions | Filters)
	 *
	 * @since    1.0.0
	 */
	protected function set_actions() {

		if(\Depc_Core::get_option( 'dc_enable_dashboard_notifications', 'Notifications' , 'on' ) == 'on' ) {

			add_action('admin_enqueue_scripts', [$this, 'enqueue_assets'], 10 );
			add_action('wp_ajax_dpr_comments_listener', [$this, 'last_notifications'], 10 );
		}
    }

    /**
	 * Enqueue Admin Styles And Scripts
	 *
	 * @since    1.0.0
	 */
    public function enqueue_assets () {

		wp_enqueue_script(
			\Depc_Core::DEPC_ID . '-admin-scripts',
			\Depc_Core::get_depc_url() . 'views/js/package/admin.js',
			array( 'jquery' ),
			Depc_Core::DEPC_VERSION,
			false
		);

	}

    /**
	 * Get Last Notifications
	 *
	 * @since    1.0.0
	 */
    public function last_notifications () {
		if(!current_user_can('administrator') ) {
			wp_send_json([]);
			wp_die();
		}
		$comments = get_comments([
			'date_query' => [
				'after'     => 'today',
				'inclusive' => true,
			],
			'meta_query' => [
				[
					'key' => 'dpr_seen',
					'compare' => 'NOT EXISTS'
				]
			]
		]);

		$result = [];
		if($comments) {
			$counter = 0;
			foreach ($comments as $ID => $comment) {
				update_comment_meta($comment->comment_ID, 'dpr_seen', time());
				$result['comments'][] = [
					'author'  => $comment->comment_author,
					'date'  => $comment->comment_date,
					'url'  => get_permalink( sanitize_key( $comment->comment_post_ID ) ) . '#comments' . '-' . $comment->comment_ID,
					'author_IP'  => $comment->comment_author_IP,
					'excerpt' => esc_html_e( substr( wp_strip_all_tags( html_entity_decode( $comment->comment_content) ), 0, 50 ) ),
				];

				$counter++;
				if($counter == 10) {
					$result['comment_count'] = count($comments) - 10;
					break;
				}
			}
		}
		wp_send_json($result);
		wp_die();
	}


}