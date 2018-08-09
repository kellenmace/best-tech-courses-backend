<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class UserFields implements Hookable {

	public function register_hooks() {
		add_filter( 'graphql_user_mutation_input_fields', [ $this, 'modify_input_fields' ] );
		add_action( 'graphql_user_object_mutation_update_additional_data', [ $this, 'update_data' ], 10, 3 );
		add_filter( 'validate_username', [ $this, 'modify_username_validation' ], 10, 2 );
	}

	public function modify_input_fields( $input_fields ) {
		$input_fields['payPalEmail'] = [
			'type'        => \WPGraphQL\Types::string(),
			'description' => __( 'The user\'s PayPal email', 'best-tech-courses' ),
			'resolve'     => $this->get_custom_field_callback( 'paypal_email', 'esc_html' ),
		];

		return $input_fields;
	}

	private function get_custom_field_callback( $slug, $escaping_cb ) {
		return function( \WP_User $user ) use ( $slug, $escaping_cb ) {
			$value = get_user_meta( $user->ID, $slug, true );
			return ! empty( $value ) ? $escaping_cb( $value ) : null;
		};
	}

	public function update_data( $user_id, $input, $mutation_name ) {
		if ( 'register' !== $mutation_name && 'update' !== $mutation_name ) {
			return;
		}

		if ( ! empty( $input['payPalEmail'] ) ) {
			update_user_meta( $user_id, 'paypal_email', sanitize_email( $input['payPalEmail'] ) );
		}
	}

	/**
	 * Relax username validation to allow additional characters, such as
	 * the the "+" in some+email@gmail.com.
	 */
	public function modify_username_validation( $valid, $username ) {
		$sanitized = sanitize_user( $username );

		return $sanitized === $username && ! empty( $sanitized );
	}
}
