<?php
namespace BestTechCourses\Controllers;

use BestTechCourses\CustomPostTypes\CustomPostType;

abstract class PostController {

	protected $post_type;

	protected $post_data_utilities;

	public function __construct( CustomPostType $post_type, PostDataUtilities $post_data_utilities ) {
		$this->post_type           = $post_type;
		$this->post_data_utilities = $post_data_utilities;
	}
}