<?php
namespace BestTechCourses\Taxonomies;

class ConfirmationStatus extends Taxonomy {

	// post types: Confirmation
	public function __construct( array $post_types ) {
		parent::__construct( 'status', $post_types );
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ], 11 );
	}

	public function register() {
		register_taxonomy(
			$this->slug,
			$this->get_post_type_slugs(),
			[
				'labels'            => $this->generate_labels( 'Status', 'Statuses' ),
				'hierarchical'      => true,
				'show_admin_column' => true,
			]
		);
	}
}
