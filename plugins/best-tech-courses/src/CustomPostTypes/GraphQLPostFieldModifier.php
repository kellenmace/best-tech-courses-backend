<?php
namespace BestTechCourses\CustomPostTypes;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\Interfaces\GraphQLFieldModifier;

abstract class GraphQLPostFieldModifier implements Hookable, GraphQLFieldModifier {

	protected $post_type;

	public function __construct( CustomPostType $post_type ) {
		$this->post_type = $post_type;
	}

	abstract public function modify( array $fields );

	protected function get_custom_field_callback( $slug, $escaping_cb ) {
		return function( \WP_Post $post ) use ( $slug, $escaping_cb ) {
			$value = get_post_meta( $post->ID, $slug, true );
			return ! empty( $value ) ? $escaping_cb( $value ) : null;
		};
	}
}
