<?php
namespace BestTechCourses\Controllers;

class PostDataUtilities {

	public function get_user_name( $post_id ) {
		$user_id = wp_get_post_terms( $post_id, 'user_id', [ 'fields' => 'names' ] );

		if ( ! $user_id || ! is_array( $user_id ) ) {
			return '';
		}

		return get_user_meta( $user_id[0], 'first_name', true ) . ' ' . get_user_meta( $user_id[0], 'last_name', true );
	}

	public function get_course_name( $post_id ) {
		$course_id = wp_get_post_terms( $post_id, 'course_id', [ 'fields' => 'names' ] );

		return $course_id && is_array( $course_id ) ? get_the_title( $course_id[0] ) : '';
	}

	public function get_formatted_datetime( $post_id, $include_time = true ) {
		$datetime = get_post_meta( $post_id, 'datetime', true );
		$format   = $include_time ? 'm/d/Y h:i a' : 'm/d/Y';

		return date( $format, strtotime( $datetime ) );
	}
}
