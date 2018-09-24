<?php
namespace BestTechCourses\Taxonomies;

class CourseCategory extends Taxonomy {

	// post types: Course
	public function __construct( array $post_types ) {
		parent::__construct( 'course_category', $post_types );
	}

	public function get_graphql_single_name() {
		return 'courseCategory';
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ], 11 );
	}

	public function register() {
		register_taxonomy(
			$this->slug,
			$this->get_post_type_slugs(),
			[
				'labels'              => $this->generate_labels( 'Category', 'Categories' ),
				'hierarchical'        => true,
				'show_in_graphql'     => true,
				'show_admin_column'   => true,
				'graphql_single_name' => $this->get_graphql_single_name(),
				'graphql_plural_name' => 'courseCategories',
			]
		);
	}
}
