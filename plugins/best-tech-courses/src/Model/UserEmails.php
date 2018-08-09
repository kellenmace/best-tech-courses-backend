<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class UserEmails implements Hookable {

	private $password_key = '';

	public function register_hooks() {
		add_action( 'retrieve_password_key', [ $this, 'set_password_key' ], 10, 2 );
		add_filter( 'wp_new_user_notification_email', [ $this, 'modify_new_user_mail' ], 10, 2 );
		add_filter( 'retrieve_password_message', [ $this, 'modify_email_reset_message' ], 10, 4 );
	}

	public function set_password_key( $user_login, $key ) {
		$this->password_key = $key;
	}

	public function modify_new_user_mail( $wp_new_user_notification_email, $user ) {
		$url     = $this->get_password_reset_url( $this->key, $user->user_login );
		$message = "Oh, hey! Thanks for signing up for Best Tech Courses! 🙌🏼\r\n\r\n"; // String contains a raised hands emoji.
		$message .= "You can set a password for your shiny new account here:\r\n{$url}";

		$wp_new_user_notification_email['subject'] = __( '⭐️ %s – Confirm your Account' ); // String contains a star emoji.
		$wp_new_user_notification_email['message'] = $message;

		return $wp_new_user_notification_email;
	}

	public function modify_email_reset_message( $message, $key, $user_login, $user_data ) {
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		$message = __( 'Someone has requested a password reset for the following account:' ) . "\r\n\r\n";
		/* translators: %s: site name */
		$message .= sprintf( __( 'Site Name: %s'), $site_name ) . "\r\n";
		/* translators: %s: user login */
		$message .= sprintf( __( 'Username:  %s'), $user_login ) . "\r\n\r\n";
		$message .= __( 'If you didn\'t request a password reset, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
		$message .= __( 'You can reset your password here:' ) . "\r\n";
		$message .= $this->get_password_reset_url( $key, $user_login );

		return $message;
	}

	private function get_password_reset_url( $key, $user_login ) {
		$login_encoded = rawurlencode( $user_login );
		return untrailingslashit( get_frontend_origin() ) . "/password-reset/?key={$key}&login={$login_encoded}";
	}
}
