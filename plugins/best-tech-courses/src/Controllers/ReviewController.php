<?php
namespace BestTechCourses\Controllers;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\CustomPostTypes\Review;

class ReviewController extends PostController implements Hookable {

	private $title_updated = false;

	public function __construct( Review $post_type, PostDataUtilities $post_data_utilities ) {
		parent::__construct( $post_type, $post_data_utilities );
	}

	public function register_hooks() {
		add_action( "save_post_{$this->post_type->get_slug()}", [ $this, 'set_title' ] );
	}

	public function set_title( $post_id ) {
		// Prevent an infinite loop.
		if ( $this->title_updated ) {
			return;
		}

		$this->title_updated = true;
		$user_name           = $this->post_data_utilities->get_user_name( $post_id );
		$course_name         = $this->post_data_utilities->get_course_name( $post_id );

		wp_update_post( [
			'ID'         => $post_id,
			'post_title' => "{$user_name} - {$course_name}",
		] );
	}


}
