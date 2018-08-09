<?php
namespace BestTechCourses\Model;

class ReviewFields extends ExposePostFields {

  public function register_hooks() {
    //add_filter( 'graphql_review_fields', [ $this, 'expose_custom_fields'] );
  }
  
  public function expose_custom_fields( $fields ) {
    // should use JWT for this:
    // $fields['userId'] = [
    //     'type'        => \WPGraphQL\Types::string(),
    //     'description' => __( 'The ID of the user who left the review', 'best-tech-courses' ),
    //     'resolve'     => $this->get_custom_field_callback( 'user_id', 'absint' ),
    // ];

    $fields['courseId'] = [
        'type'        => \WPGraphQL\Types::string(),
        'description' => __( 'The ID of the reviewed course', 'best-tech-courses' ),
        'resolve'     => $this->get_custom_field_callback( 'course_id', 'absint' ),
    ];

    return $fields;
  }
}
