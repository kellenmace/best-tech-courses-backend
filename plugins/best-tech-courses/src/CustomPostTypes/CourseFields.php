<?php
namespace BestTechCourses\CustomPostTypes;

use WPGraphQL\Types;

class CourseFields extends GraphQLPostFieldModifier {

	public function __construct( Course $post_type ) {
		parent::__construct( $post_type );
	}

	public function register_hooks() {
		// @TODO: consider putting get_graphql_single_name in CustomPostType as an abstract method.
		add_filter( "graphql_{$this->post_type->get_graphql_single_name()}_fields", [ $this, 'modify' ] );
	}

	public function modify( $fields ) {
		$fields['instructor'] = [
			'type'        => Types::string(),
			'description' => __( 'The instructor of the course', 'best-tech-courses' ),
			'resolve'     => $this->get_custom_field_callback( 'instructor', 'esc_html' ),
		];

		$fields['discount'] = [
			'type'        => Types::string(),
			'description' => __( 'The discount amount', 'best-tech-courses' ),
			'resolve'     => $this->get_custom_field_callback( 'discount', 'esc_html' ),
		];

		$fields['affiliateLink'] = [
			'type'        => Types::string(),
			'description' => __( 'The affiliate link URL', 'best-tech-courses' ),
			'resolve'     => $this->get_custom_field_callback( 'affiliate_link', 'esc_url' ),
		];

		return $fields;
	}
}
