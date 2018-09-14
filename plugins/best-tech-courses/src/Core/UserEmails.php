<?php
namespace BestTechCourses\Core;

use BestTechCourses\Interfaces\Hookable;

class UserEmails implements Hookable {

	private $password_key = '';

	private $site_name = '';

	public function register_hooks() {
		add_action( 'retrieve_password_key', [ $this, 'set_password_key' ], 10, 2 );
		add_filter( 'wp_mail_from_name', [ $this, 'modify_mail_from_name' ] );
		add_filter( 'wp_mail_from', [ $this, 'modify_mail_from_address' ] );
		add_filter( 'wp_new_user_notification_email', [ $this, 'modify_new_user_mail' ], 10, 2 );
		add_filter( 'retrieve_password_title', [ $this, 'modify_email_reset_subject'] );
		add_filter( 'retrieve_password_message', [ $this, 'modify_email_reset_message' ], 10, 4 );
	}

	public function set_password_key( $user_login, $key ) {
		$this->password_key = $key;
	}

	public function modify_mail_from_name() {
		return $this->get_site_name();
	}

	public function modify_mail_from_address() {
		return 'noreply@' . $this->get_backend_domain();
	}

	private function get_backend_domain() {
		return (string) parse_url( home_url(), PHP_URL_HOST );
	}

	public function modify_new_user_mail( $wp_new_user_notification_email, $user ) {
		$wp_new_user_notification_email['subject'] = __( '⭐️ %s – Confirm your Account' ); // String contains a star emoji.
		$wp_new_user_notification_email['message'] = $this->get_new_user_email_message();

		return $wp_new_user_notification_email;
	}

	private function get_new_user_email_message() {
		$url     = $this->get_password_reset_url( $this->password_key, $user->user_login );
		$message = "Hey – thanks for signing up for Best Tech Courses! 🙌🏼\r\n\r\n"; // String contains a raised hands emoji.
		$message .= "You can set a password for your shiny new account here:\r\n{$url}";

		return $message;
	}

	public function modify_email_reset_subject() {
		return sprintf( __( '⭐️ %s – Password Reset' ), $this->get_site_name() ); // String contains a star emoji.
	}

	public function modify_email_reset_message( $message, $key, $user_login, $user_data ) {
		$message = __( "A password reset has been requested for the following {$this->get_site_name()} account: {$user_data->user_email}." ) . "\r\n\r\n";
		$message .= __( 'If you didn\'t request a password reset, you can safely ignore this email.' ) . "\r\n\r\n";
		$message .= __( 'You can reset your password here:' ) . "\r\n";
		$message .= $this->get_password_reset_url( $key, $user_login );

		return $message;
	}

	private function get_site_name() {
		if ( ! $this->site_name ) {
			$this->set_site_name();
		}

		return $this->site_name;
	}

	private function set_site_name() {
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$this->site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	private function get_password_reset_url( $key, $user_login ) {
		$login_encoded = rawurlencode( $user_login );
		return untrailingslashit( get_frontend_origin() ) . "/set-password/?key={$key}&login={$login_encoded}";
	}
}
