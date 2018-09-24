<?php
namespace BestTechCourses\Admin;

use BestTechCourses\CustomPostTypes\Course;
use BestTechCourses\Controllers\PostDataUtilities;

class CourseAdminColumns extends AdminColumnsHandler {

	public function __construct( Course $post_type, PostDataUtilities $post_data_utilities ) {
		parent::__construct( $post_type, $post_data_utilities );
	}

	public function register_hooks() {
		add_filter( "manage_{$this->post_type->get_slug()}_posts_columns",       [ $this, 'modify' ] );
		add_action( "manage_{$this->post_type->get_slug()}_posts_custom_column", [ $this, 'render' ], 10, 2 );
	}

	public function modify( $columns ) {
		return [
			'cb'                       => $columns['cb'],
			'title'                    => $columns['title'],
			'discount'                 => 'Discount',
			'taxonomy-course_category' => $columns['taxonomy-course_category'],
			'date'                     => $columns['date'],
		];
	}

	public function render( $column, $post_id ) {
		if ( 'discount' !== $column ) {
			return;
		}

		echo esc_html( '$' . get_post_meta( $post_id, 'discount', true ) );
	}
}
