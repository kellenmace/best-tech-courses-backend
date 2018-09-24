<?php
namespace BestTechCourses\Taxonomies;

class UserId extends Taxonomy {

	// post types: AffiliateLinkClick, Review, Confirmation, Payment
	public function __construct( array $post_types ) {
		parent::__construct( 'user_id', $post_types );
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ], 11 );
	}

	public function register() {
		register_taxonomy(
			$this->slug,
			$this->get_post_type_slugs(),
			[
				'labels'              => $this->generate_labels( 'User ID', 'User ID' ),
				'hierarchical'        => true,
				'show_admin_column'   => true,
				'single_value'        => true,
				'show_in_graphql'     => true,
				'graphql_single_name' => 'userId',
				'graphql_plural_name' => 'userIds',
			]
		);
	}
}
