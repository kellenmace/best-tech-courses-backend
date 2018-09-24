<?php
namespace BestTechCourses\Controllers;

use BestTechCourses\Interfaces\Hookable;

class UserController implements Hookable {

	public function register_hooks() {
		add_action( 'graphql_user_object_mutation_update_additional_data', [ $this, 'update_paypal_email' ], 10, 3 );
	}

	public function update_paypal_email( $user_id, $input, $mutation_name ) {
		if ( 'register' !== $mutation_name && 'update' !== $mutation_name ) {
			return;
		}

		if ( empty( $input['payPalEmail'] ) ) {
			return;
		}

		update_user_meta( $user_id, 'paypal_email', sanitize_email( $input['payPalEmail'] ) );
	}
}
