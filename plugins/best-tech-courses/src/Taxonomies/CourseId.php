<?php
namespace BestTechCourses\Taxonomies;

use BestTechCourses\CustomPostTypes\AffiliateLinkClick;
use BestTechCourses\CustomPostTypes\Review;
use BestTechCourses\CustomPostTypes\Confirmation;

class CourseId extends Taxonomy {

	// post types: AffiliateLinkClick, Confirmation Review
	public function __construct( array $post_types ) {
		parent::__construct( 'course_id', $post_types );
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ], 11 );
	}

	public function register() {
		register_taxonomy(
			$this->slug,
			$this->get_post_type_slugs(),
			[
				'labels'              => $this->generate_labels( 'Course ID', 'Course ID' ),
				'hierarchical'        => true,
				'show_in_graphql'     => true,
				'show_admin_column'   => true,
				'graphql_single_name' => 'courseId',
				'graphql_plural_name' => 'courseIds',
			]
		);
	}
}
