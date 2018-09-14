<?php
namespace BestTechCourses\Core;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\Interfaces\UpdatePostData;

class AffiliateLinkClickFields implements Hookable, UpdatePostData {

	public function register_hooks() {
		add_action( 'graphql_post_object_mutation_update_additional_data', [ $this, 'update_data' ], 10, 3 );
	}

	public function update_data( $post_id, $input, \WP_Post_Type $post_type_object ) {
		if ( 'affiliate_link_click' !== $post_type_object->name || empty( $input['courseIds']['nodes'][0] ) ) {
			return;
		}

		// Set userId taxonomy term based on current user's ID.
		wp_set_object_terms( $post_id, (string) get_current_user_id(), 'user_id' );

		// Save discount amount.
		$course_id = absint( $input['courseIds']['nodes'][0]['slug'] );
		$discount  = get_post_meta( $course_id, 'discount', true );
		update_post_meta( $post_id, 'discount', $discount );

		// Save current timestamp.
		// TODO: maybe adjust to be in eastern time? Check how the ACF field does it.
		// DateTime in admin column is also broken
		update_post_meta( $post_id, 'datetime', time() );
	}
}
