<?php

/**
 * @link       http://webnus.biz
 * @since      2.0.0
 *
 * @package    Deeper Comments
 */

class Depc_Controller_Notification{

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

			add_action('deeper_comments_new_comment', [$this, 'send_comment_author_notification'], 10, 2);
			add_action('deeper_comments_new_comment', [$this, 'send_comment_admin_notification'], 10, 2);
			add_action('transition_comment_status', [$this,'send_comment_approved_author_notification'], 10, 3);
			add_action('transition_comment_status', [$this,'send_comment_approved_admin_notification'], 10, 3);
		}

		if ( \Depc_Request_Validator::is_ajax() ) {
			add_action('wp_ajax_dpr_user_comments_listener', [$this, 'notification_handler'], 10);
		}
    }

	/**
	 * Notification Handler
	 *
	 * @since    1.0.0
	 */
    public function notification_handler () {
		if(\Depc_Core::get_option( 'dc_enable_user_notifications', 'Notifications' , 'on' ) != 'on') {
			return;
		}

		$user_id = get_current_user_id();

		if(!$user_id) {
			wp_die();
		}

		$user_meta_data = get_user_meta ( $user_id );
		$comments = $results = [];
		foreach ($user_meta_data as $meta => $data) {
			if($data[0] == 'dpr_followed') {
				$comments[] = $meta;
			}
		}

		foreach ($comments as $comment_id) {

			$child_comments = get_comments(array(
				'status'    => 'approve',
				'parent'    => $comment_id,
			));

			foreach ($child_comments as $child) {

				if(!get_comment_meta($child->comment_ID, 'dpr_seen_' . $user_id , true) &&
					get_user_meta($user_id, 'dpr_followed_time' . $child->comment_ID , true) < strtotime( $child->comment_date) &&
					$child->user_id != $user_id){

					update_comment_meta($child->comment_ID, 'dpr_seen_' . $user_id , time());
					$results['comments'][] = [
						'author'  => $child->comment_author,
						'date'  => $child->comment_date,
						'url'  => get_permalink( sanitize_key( $child->comment_post_ID ) ) . '#comments' . '-' . $child->comment_ID,
						'excerpt' => substr(trim(strip_tags($child->comment_content)), 0, 120),
					];
				}

			}

		}
		wp_send_json($results);
		wp_die();
	}

	/**
	 * Send notification when a new comment is posted for author
	 *
	 * @since    2.0.0
	 */
    public function send_comment_author_notification ($comment_id, $comment_data) {

		$recipients = $comment_data['comment_author_email'];
		$this->send_notification($recipients, 'author', '',$comment_data, $comment_id);
    }

	/**
	 * Send notification when comment is approved
	 *
	 * @since    2.1.0
	 */
    public function send_comment_approved_author_notification ($new_status, $old_status, $comment_data) {

		if('approved' !== $new_status){

			return;
		}

		if(false === (bool)get_option('comment_moderation')){

			return;
		}

		$comment_data = (array)$comment_data;
		$comment_id = $comment_data['comment_ID'];

		$recipients = $comment_data['comment_author_email'];
		$this->send_notification($recipients, 'author', 'approved', $comment_data, $comment_id);
    }

	/**
	 * Send notification when a new comment is posted for admin
	 *
	 * @since    2.1.0
	 */
    public function send_comment_admin_notification ($comment_id, $comment_data) {

		$recipients = \Depc_Core::get_option( 'dc_notifications_admin_email', 'Notifications' , get_option('admin_email') );
		$this->send_notification($recipients, 'admin', '', $comment_data, $comment_id);
    }

	/**
	 * Send notification when comment is approved
	 *
	 * @since    2.1.0
	 */
    public function send_comment_approved_admin_notification ($new_status, $old_status, $comment_data) {

		if('approved' !== $new_status){

			return;
		}

		if(false === (bool)get_option('comment_moderation')){

			return;
		}

		$comment_data = (array)$comment_data;
		$comment_id = $comment_data['comment_ID'];

		$recipients = \Depc_Core::get_option( 'dc_notifications_admin_email', 'Notifications' , get_option('admin_email') );
		$this->send_notification($recipients, 'admin', 'approved', $comment_data, $comment_id);
    }

	/**
	 * Send notification after check settings
	 *
	 * @since    2.1.0
	 */
	public function send_notification( $recipients, $role, $notification_type, $comment_data, $comment_id ){

		if( current_user_can('editor') || current_user_can('administrator') ) {
			return;
		}

		$is_comment_approved = wp_get_comment_status( $comment_id ) == 'approved';
		$notification_key = 'approved' !== $notification_type ? $role : $role . '_after_approved';

		$is_enabled_notification = \Depc_Core::get_option( 'dc_enable_notifications_for_'.$notification_key, 'Notifications' , 'on' ) != 'on';
		if($is_enabled_notification) {

			return;
		}

		if( 'approved' === $notification_type && !$is_comment_approved ){

			return;
		}

		$is_sended = (bool)get_comment_meta($comment_id,'mec_'.$notification_key.'_sended_notification',true);
		if($is_sended){

			return;
		}

		$subject = \Depc_Core::get_option(
			'dc_notifications_'.$notification_key.'_subject', 'Notifications' ,
			self::get_default( 'subject', $role, $notification_type )
		);
		$body = \Depc_Core::get_option(
			'dc_notifications_'.$notification_key.'_email_body', 'Notifications' ,
			self::get_default( 'content', $role, $notification_type )
		);

		$sended = $this->send_mail($recipients,$subject,$body,$comment_data, $comment_id );

		if($sended){

			update_comment_meta($comment_id,'mec_'.$notification_key.'_sended_notification',1);
		}

		return $sended;
	}

	public static function get_default($key,$role_id,$notification_type){

		switch($key){

			case 'subject':

				if(in_array($notification_type,['_after_approved','approved'])){

					$default = ('admin' === $role_id) ? __('Comment approved on %site_name','depc') : __('Your comment approved on %site_name','depc');
				}else{

					$default = ('admin' === $role_id) ? __('New comment on %site_name','depc') : __('Your comment on %site_name','depc');
				}

				break;
			case 'content':

				if(in_array($notification_type,['_after_approved','approved'])){

					if('admin' === $role_id){

						$default = __('Dear %author_name,<br>
							a new comment has been successfully posted on %post_title with the email %author_email<br>
							Read your comment on <a href="%comment_url">%comment_url</a> .<br>
							Best,<br>
							<a href="%site_address">%site_name</a>'
						,'depc');
					}else{

						$default = __('Dear %author_name,<br>
							Your comment on %post_title with the email %author_email has been approved<br>
							Read your comment on <a href="%comment_url">%comment_url</a> .<br>
							Best,<br>
							<a href="%site_address">%site_name</a>'
						,'depc');
					}
				}else{

					if('admin' === $role_id){

						$default = __('Dear Admin,<br>
							a new comment has been successfully posted on %post_title with the email %author_email<br>
							Read the comment on <a href="%comment_url">%comment_url</a> .<br>
							Best,<br>
							<a href="%site_address">%site_name</a>'
						,'depc');
					}else{

						$default = __('Dear %author_name,<br>
							Your comment has been successfully posted on %post_title with the email %author_email<br>
							Read your comment on <a href="%comment_url">%comment_url</a> .<br>
							Best,<br>
							<a href="%site_address">%site_name</a>'
						,'depc');
					}
				}



				break;
		}

		return $default;
	}

	/**
	 * Send Mail
	 *
	 * @since    2.1.0
	 */
	public function send_mail( $recipients, $subject, $body, $comment_data, $comment_id ){

		if(!$recipients) {

			return;
		}

		$headers = array('Content-Type: text/html; charset=UTF-8');

		$meta = [
			'%comment_url' => get_permalink( sanitize_key( $comment_data['comment_post_ID'] ) ) . '#comments' . '-' . $comment_id,
			'%site_address' => get_option('siteurl'),
			'%site_name' => get_option('blogname'),
			'%author_name' => isset($comment_data['comment_author']) && $comment_data['comment_author'] ? $comment_data['comment_author'] : get_the_author_meta('display_name', $comment_data['comment_author']),
			'%author_email' => $comment_data['comment_author_email'],
			'%author_url' => $comment_data['comment_author_url'],
			'%comment_content' => $comment_data['comment_content'],
			'%post_title' => get_the_title($comment_data['comment_post_ID']),
			'%post_url' => get_permalink($comment_data['comment_post_ID']),
		];
		$subject = str_replace(['%comment_url', '%site_address', '%site_name', '%author_name', '%author_email', '%author_url', '%post_title', '%comment_content'], $meta, $subject);
		$body = str_replace(['%comment_url', '%site_address', '%site_name', '%author_name', '%author_email', '%author_url', '%post_title', '%comment_content'], $meta, $body);

		return wp_mail( $recipients, $subject, $body, $headers );
	}
}