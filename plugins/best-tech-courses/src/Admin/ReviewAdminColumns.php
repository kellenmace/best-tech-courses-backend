<?php
namespace BestTechCourses\Admin;

use BestTechCourses\CustomPostTypes\Review;
use BestTechCourses\Controllers\PostDataUtilities;

class ReviewAdminColumns extends AdminColumnsHandler {

	public function __construct( Review $post_type, PostDataUtilities $post_data_utilities ) {
		parent::__construct( $post_type, $post_data_utilities );
	}

	public function register_hooks() {
		add_filter( "manage_{$this->post_type->get_slug()}_posts_columns",       [ $this, 'modify' ] );
		add_action( "manage_{$this->post_type->get_slug()}_posts_custom_column", [ $this, 'render' ], 10, 2 );
	}

	public function modify( $columns ) {
		return [
			'cb'       => $columns['cb'],
			'title'    => $columns['title'],
			'user'     => 'User',
			'course'   => 'Course',
			'datetime' => 'Date',
		];
	}

	public function render( $column, $post_id ) {
		switch ( $column ) {
			case 'user':
				echo esc_html( $this->post_data_utilities->get_user_name( $post_id ) );
				break;
			case 'course':
				echo esc_html( $this->post_data_utilities->get_course_name( $post_id ) );
				break;
			case 'datetime':
				echo esc_html( $this->post_data_utilities->get_formatted_datetime( $post_id ) );
				break;
		}
	}
}
