<?php
namespace BestTechCourses\CustomPostTypes;

class Review extends CustomPostType {

	public function __construct() {
		parent::__construct( 'review' );
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
	}

	public function register() {
		register_post_type( $this->slug, [
			'labels'              => $this->generate_labels( 'Review', 'Reviews' ),
			'public'              => true,
			'menu_position'       => 28,
			'menu_icon'           => 'dashicons-thumbs-up',
			'supports'            => [ 'title', 'editor' ],
			'show_in_graphql'     => true,
			'graphql_single_name' => 'review',
			'graphql_plural_name' => 'reviews',
		] );
	}
}
