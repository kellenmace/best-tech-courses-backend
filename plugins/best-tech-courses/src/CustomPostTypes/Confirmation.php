<?php
namespace BestTechCourses\CustomPostTypes;

class Confirmation extends CustomPostType {

	public function __construct() {
		parent::__construct( 'confirmation' );
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
	}

	public function register() {
		register_post_type( $this->slug, [
			'labels'        => $this->generate_labels( 'Confirmation', 'Confirmations' ),
			'public'        => true,
			'menu_position' => 29,
			'menu_icon'     => 'dashicons-yes',
			'supports'      => false,
		] );
	}
}
