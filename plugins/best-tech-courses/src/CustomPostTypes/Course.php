<?php
namespace BestTechCourses\CustomPostTypes;

class Course extends CustomPostType {

	public function __construct() {
		parent::__construct( 'course' );
	}

	public function get_graphql_single_name() {
		return 'course';
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
	}

	public function register() {
		register_post_type( $this->slug, [
			'labels'              => $this->generate_labels( 'Course', 'Courses' ),
			'public'              => true,
			'menu_position'       => 26,
			'menu_icon'           => 'dashicons-format-video',
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
			'show_in_graphql'     => true,
			'graphql_single_name' => $this->get_graphql_single_name(),
			'graphql_plural_name' => 'courses',
		] );
	}
}
