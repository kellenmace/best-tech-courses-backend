<?php
namespace BestTechCourses\Controllers;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\CustomPostTypes\AffiliateLinkClick;

class AffiliateLinkClickController extends PostController implements Hookable {

	public function __construct( AffiliateLinkClick $post_type, PostDataUtilities $post_data_utilities ) {
		parent::__construct( $post_type, $post_data_utilities );
	}

	public function register_hooks() {
		add_action( 'graphql_post_object_mutation_update_additional_data', [ $this, 'save_additional_data' ], 10, 3 );
	}

	public function save_additional_data( $post_id, $input, \WP_Post_Type $post_type_object ) {
		if ( empty( $input['courseIds']['nodes'][0] ) || $this->post_type->get_slug() !== $post_type_object->name ) {
			return;
		}

		$this->save_user_id_term( $post_id );
		$this->save_discount_amount( $post_id, $input );
		$this->save_datetime( $post_id );
		$this->update_title( $post_id );
	}

	private function save_user_id_term( $post_id ) {
		wp_set_object_terms( $post_id, (string) get_current_user_id(), 'user_id' );
	}

	private function save_discount_amount( $post_id, $input ) {
		update_post_meta( $post_id, 'discount', $this->get_course_discount_amount( $input ) );
	}

	private function get_course_discount_amount( $input ) {
		return get_post_meta( $this->get_course_id_from_input( $input ), 'discount', true ) ?: '';
	}

	private function get_course_id_from_input( $input ) {
		return ! empty( $input['courseIds']['nodes'][0]['slug'] ) ? absint( $input['courseIds']['nodes'][0]['slug'] ) : 0;
	}

	private function save_datetime( $post_id ) {
		// Saves in YYYY-MM-DD HH:MM:SS format, in the site's local timezone.
		update_post_meta( $post_id, 'datetime', current_time( 'mysql' ) );
	}

	private function update_title( $post_id ) {
		$user_name   = $this->post_data_utilities->get_user_name( $post_id );
		$course_name = $this->post_data_utilities->get_course_name( $post_id );

		wp_update_post( [
			'ID'         => $post_id,
			'post_title' => "{$user_name} - {$course_name}",
		] );
	}
}