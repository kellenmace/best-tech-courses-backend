<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class User implements Hookable {

	public function register_hooks() {
		add_action( 'user_register', [ $this, 'set_user_id' ] );
		add_action( 'profile_update', [ $this, 'set_user_id' ] );
	}

	public function set_user_id( $user_id ) {
		wp_set_object_terms( $user_id, (string) $user_id, 'user_id' );
	}
}
