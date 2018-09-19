<?php
namespace BestTechCourses\Core;

class AffiliateLinkClick extends CustomPostType {

	private $slug = 'affiliate_link_click';

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
		add_action( 'graphql_post_object_mutation_update_additional_data', [ $this, 'save_additional_data' ], 10, 3 );
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

	public function save_additional_data( $post_id, $input, \WP_Post_Type $post_type_object ) {
		if ( 'affiliate_link_click' !== $post_type_object->name || empty( $input['courseIds']['nodes'][0] ) ) {
			return;
		}

		$this->save_user_id_term( $post_id );
		$this->save_discount_amount( $post_id, $input );
		$this->save_datetime( $post_id );
		$this->update_title( $post_id );
	}

	private function save_user_id_term( $post_id ) {
		wp_set_object_terms( $post_id, (string) get_current_user_id(), 'user_id' );
	}

	private function save_discount_amount( $post_id, $input ) {
		update_post_meta( $post_id, 'discount', $this->get_course_discount_amount( $input ) );
	}

	private function get_course_discount_amount( $input ) {
		return get_post_meta( $this->get_course_id_from_input( $input ), 'discount', true ) ?: '';
	}

	private function get_course_id_from_input( $input ) {
		return ! empty( $input['courseIds']['nodes'][0]['slug'] ) ? absint( $input['courseIds']['nodes'][0]['slug'] ) : 0;
	}

	private function save_datetime( $post_id ) {
		// Saves in YYYY-MM-DD HH:MM:SS format, in the site's local timezone.
		update_post_meta( $post_id, 'datetime', current_time( 'mysql' ) );
	}

	private function update_title( $post_id ) {
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
