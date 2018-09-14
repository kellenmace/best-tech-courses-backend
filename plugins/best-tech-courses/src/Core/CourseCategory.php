<?php
namespace BestTechCourses\Core;

use BestTechCourses\Interfaces\Hookable;

class CourseCategory extends Taxonomy implements Hookable {

	public function register_hooks() {
		add_action( 'init', [ $this, 'register_taxonomy' ], 11 );
	}

	public function register_taxonomy() {
		register_taxonomy(
			'course_category',
			'course',
			[
				'labels'              => $this->generate_labels( 'Category', 'Categories' ),
				'hierarchical'        => true,
				'show_in_graphql'     => true,
				'show_admin_column'   => true,
				'graphql_single_name' => 'courseCategory',
				'graphql_plural_name' => 'courseCategories',
			]
		);
	}
}
