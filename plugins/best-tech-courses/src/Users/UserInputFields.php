<?php
namespace BestTechCourses\Users;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\Interfaces\GraphQLInputFieldModifier;
use \WPGraphQL\Types;

class UserInputFields implements Hookable, GraphQLInputFieldModifier {

	public function register_hooks() {
		add_filter( 'graphql_user_mutation_input_fields', [ $this, 'modify' ] );
	}

	public function modify( array $input_fields ) {
		$input_fields['payPalEmail'] = [
			'type'        => Types::string(),
			'description' => __( 'The user\'s PayPal email', 'best-tech-courses' ),
			'resolve'     => $this->get_custom_field_callback( 'paypal_email', 'esc_html' ),
		];

		return $input_fields;
	}

	private function get_custom_field_callback( $slug, $escaping_cb ) {
		return function ( \WP_User $user ) use ( $slug, $escaping_cb ) {
			$value = get_user_meta( $user->ID, $slug, true );
			return ! empty( $value ) ? $escaping_cb( $value ) : null;
		};
	}
}
