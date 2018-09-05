<?php
namespace BestTechCourses\Model;

class Course extends CustomPostType {

	public function register_hooks() {
		add_action( 'init', [ $this, 'register' ] );
		add_action( 'save_post_course', [ $this, 'set_course_id' ] );
		add_filter( 'manage_course_posts_columns' , [ $this, 'modify_admin_columns' ] );
		add_action( 'manage_course_posts_custom_column' , [ $this, 'render_discount_column' ], 10, 2 );
	}

	public function register() {
		register_post_type( 'course', [
			'labels'              => $this->generate_labels( 'Course', 'Courses' ),
			'public'              => true,
			'menu_position'       => 26,
			'menu_icon'           => 'dashicons-format-video',
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
			'show_in_graphql'     => true,
			'graphql_single_name' => 'course',
			'graphql_plural_name' => 'courses',
		] );
	}

	public function set_course_id( $post_ID ) {
		wp_set_object_terms( $post_ID, (string) $post_ID, 'course_id' );
	}

	public function modify_admin_columns( $old_columns ) {
		return [
			'cb'                       => $old_columns['cb'],
			'title'                    => $old_columns['title'],
			'discount'                 => 'Discount',
			'taxonomy-course_category' => $old_columns['taxonomy-course_category'],
			'date'                     => $old_columns['date'],
		];
	}

	public function render_discount_column( $column, $post_id ) {
		if ( 'discount' !== $column ) {
			return;
		}

		echo esc_html( '$' . get_post_meta( $post_id, 'discount', true ) );
	}
}
