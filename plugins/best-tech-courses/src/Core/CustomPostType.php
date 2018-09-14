<?php
namespace BestTechCourses\Core;

use BestTechCourses\Interfaces\Hookable;

abstract class CustomPostType implements Hookable {

	abstract public function register();

	protected function generate_labels( $singular, $plural ) {
		return [
			'name'               => _x( $plural, 'post type general name', 'best-tech-courses' ),
			'singular_name'      => _x( $singular, 'post type singular name', 'best-tech-courses' ),
			'menu_name'          => _x( $plural, 'admin menu', 'best-tech-courses' ),
			'name_admin_bar'     => _x( $singular, 'add new on admin bar', 'best-tech-courses' ),
			'add_new'            => _x( 'Add New', $singular, 'best-tech-courses' ),
			'add_new_item'       => __( "Add New {$singular}", 'best-tech-courses' ),
			'new_item'           => __( "New {$singular}", 'best-tech-courses' ),
			'edit_item'          => __( "Edit {$singular}", 'best-tech-courses' ),
			'view_item'          => __( "View {$singular}", 'best-tech-courses' ),
			'all_items'          => __( "All {$plural}", 'best-tech-courses' ),
			'search_items'       => __( "Search {$plural}", 'best-tech-courses' ),
			'parent_item_colon'  => __( "Parent {$plural}:", 'best-tech-courses' ),
			'not_found'          => __( "No {$plural} found.", 'best-tech-courses' ),
			'not_found_in_trash' => __( "No {$plural} found in Trash.", 'best-tech-courses' )
		];
	}

	protected function get_course_name( $post_id ) {
		$course_id = wp_get_post_terms( $post_id, 'course_id', [ 'fields' => 'names' ] );

		return $course_id && is_array( $course_id ) ? get_the_title( $course_id[0] ) : '';
	}

	protected function get_user_name( $post_id ) {
		$user_id = wp_get_post_terms( $post_id, 'user_id', [ 'fields' => 'names' ] );

		if ( ! $user_id || ! is_array( $user_id ) ) {
			return '';
		}

		return get_user_meta( $user_id[0], 'first_name', true ) . ' ' . get_user_meta( $user_id[0], 'last_name', true );
	}

	protected function get_formatted_datetime( $post_id, $include_time = true ) {
		$datetime = get_post_meta( $post_id, 'datetime', true );
		$format   = $include_time ? 'm/d/Y h:i a' : 'm/d/Y';

		return date( $format, strtotime( $datetime ) );
	}
}
