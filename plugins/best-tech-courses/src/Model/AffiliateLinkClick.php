<?php
namespace BestTechCourses\Model;

class AffiliateLinkClick extends CustomPostType {

	private $slug          = 'affiliate_link_click';
	private $title_updated = false;

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
		add_action( "save_post_{$this->slug}", [ $this, 'set_title_on_save' ] );
		add_filter( "manage_{$this->slug}_posts_columns" , [ $this, 'modify_admin_columns' ] );
		add_action( "manage_{$this->slug}_posts_custom_column" , [ $this, 'render_custom_columns' ], 10, 2 );
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

	public function set_title_on_save( $post_id ) {
		// Prevent an infinite loop.
		if ( $this->title_updated ) {
			return;
		}

		$this->title_updated = true;

		wp_update_post( [
			'ID'         => $post_id,
			'post_title' => $this->get_user_name( $post_id ) . ' - ' . $this->get_course_name( $post_id ),
		] );
	}

	public function modify_admin_columns( $old_columns ) {
		return [
			'cb'       => $old_columns['cb'],
			'title'    => $old_columns['title'],
			'user'     => 'User',
			'course'   => 'Course',
			'datetime' => 'Date',
		];
	}

	public function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'user':
				echo esc_html( $this->get_user_name( $post_id ) );
				break;
			case 'course':
				echo esc_html( $this->get_course_name( $post_id ) );
				break;
			case 'datetime':
				echo esc_html( $this->get_formatted_datetime( $post_id ) );
				break;
		}
	}
}