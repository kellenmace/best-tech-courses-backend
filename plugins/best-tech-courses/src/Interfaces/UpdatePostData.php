<?php
namespace BestTechCourses\Interfaces;

interface UpdatePostData {
	public function update_data( $post_id, $input, \WP_Post_Type $post_type_object );
}
