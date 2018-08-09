<?php
namespace BestTechCourses\Utilities;

interface ModifyPostInputFields {
	public function modify_input_fields( $input_fields, \WP_Post_Type $post_type_object );
}
