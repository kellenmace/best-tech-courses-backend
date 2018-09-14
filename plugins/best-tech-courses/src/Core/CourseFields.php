<?php
namespace BestTechCourses\Core;

class CourseFields extends ExposePostFields {

  public function register_hooks() {
    add_filter( 'graphql_course_fields', [ $this, 'expose_custom_fields'] );
  }

  public function expose_custom_fields( $fields ) {
    $fields['instructor'] = [
      'type'        => \WPGraphQL\Types::string(),
      'description' => __( 'The instructor of the course', 'best-tech-courses' ),
      'resolve'     => $this->get_custom_field_callback( 'instructor', 'esc_html' ),
    ];

    $fields['discount'] = [
      'type'        => \WPGraphQL\Types::string(),
      'description' => __( 'The discount amount', 'best-tech-courses' ),
      'resolve'     => $this->get_custom_field_callback( 'discount', 'esc_html' ),
    ];

    $fields['affiliateLink'] = [
      'type'        => \WPGraphQL\Types::string(),
      'description' => __( 'The affiliate link URL', 'best-tech-courses' ),
      'resolve'     => $this->get_custom_field_callback( 'affiliate_link', 'esc_url' ),
    ];

    return $fields;
  }
}
