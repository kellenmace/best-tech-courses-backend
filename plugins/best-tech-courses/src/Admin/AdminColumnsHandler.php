<?php
namespace BestTechCourses\Admin;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\CustomPostTypes\CustomPostType;
use BestTechCourses\Controllers\PostDataUtilities;

abstract class AdminColumnsHandler implements Hookable {

	protected $post_type;

	protected $post_data_utilities;

	public function __construct( CustomPostType $post_type, PostDataUtilities $post_data_utilities ) {
		$this->post_type           = $post_type;
		$this->post_data_utilities = $post_data_utilities;
	}

	abstract public function modify( $columns );

	abstract public function render( $column, $post_id );
}
