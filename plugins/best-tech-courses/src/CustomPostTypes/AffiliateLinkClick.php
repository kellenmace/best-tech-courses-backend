<?php
namespace BestTechCourses\CustomPostTypes;

class AffiliateLinkClick extends CustomPostType {

	public function __construct() {
		parent::__construct( 'affiliate_link_click' );
	}

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
	}

	public function register() {
		register_post_type( $this->slug, [
			'labels'              => $this->generate_labels( 'Affiliate Link Click', 'Affiliate Link Clicks' ),
			'public'              => true,
			'menu_position'       => 27,
			'menu_icon'           => 'dashicons-migrate',
			'supports'            => false,
			'show_in_graphql'     => true,
			'graphql_single_name' => 'affiliateLinkClick',
			'graphql_plural_name' => 'affiliateLinkClicks',
		] );
	}
}
