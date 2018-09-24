<?php
namespace BestTechCourses\Users;

use BestTechCourses\Interfaces\Hookable;

class User implements Hookable {

	public function register_hooks() {
		add_filter( 'validate_username', [ $this, 'modify_username_validation' ], 10, 2 );
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