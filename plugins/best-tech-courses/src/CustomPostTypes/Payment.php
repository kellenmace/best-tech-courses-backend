<?php
namespace BestTechCourses\CustomPostTypes;

class Payment extends CustomPostType {

	public function __construct() {
		parent::__construct( 'payment' );
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
	}

	public function register() {
		register_post_type( $this->slug, [
			'labels'        => $this->generate_labels( 'Payment', 'Payments' ),
			'public'        => true,
			'menu_position' => 30,
			'menu_icon'     => 'dashicons-tickets-alt',
			'supports'      => false,
		] );
	}
}
