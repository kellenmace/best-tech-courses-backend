<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class AffiliateLinkClickFields extends AbstractGraphQL implements Hookable, GraphQL {

  public function register_hooks() {
    add_filter( 'graphql_AffiliateLinkClick_fields', [ $this, 'expose_custom_fields'] );
    add_action( 'graphql_post_object_mutation_input_fields', [ $this, 'register_input_fields' ] );
    add_action( 'graphql_post_object_mutation_update_additional_data', [ $this, 'mutation_callback' ] );
  }
  
  public function expose_custom_fields( $fields ) {
    $fields['courseId'] = [
        'type'        => \WPGraphQL\Types::string(),
        'description' => __( 'The ID of the course', 'best-tech-courses' ),
        'resolve'     => $this->get_custom_field_callback( 'course_id', 'absint' ),
    ];

    return $fields;
  }

  public function register_input_fields( $fields, \WP_Post_Type $post_type_object ) {
    if ( 'affiliate_link_click' === $post_type_object->name ) {
      $fields['courseId'] = [
        'type'        => \WPGraphQL\Types::string(),
        'description' => __( 'Mutation for writing courseId to database', 'best-tech-courses' ),
      ];
    }
    return $fields;
  }

  public function mutation_callback( $post_id, $input, \WP_Post_Type $post_type_object ) {
    if ( 'affiliate_link_click' !== $post_type_object->name || empty( $input['courseId'] ) ) {
      return;
    }

    $course_id = absint( $input['courseId'] );
    $discount  = get_post_meta( $course_id, 'discount', true );

    // TODO: Get user ID from JWT.
    // update_post_meta( $post_id, 'user_id', absint( $input['courseId'] ) );

    // TODO: Add capability checks to fields:
    // https://github.com/wp-graphql/wp-graphql/wiki/Extending-and-Customizing#add-capability-checks-to-fields

    update_post_meta( $post_id, 'course_id', $course_id );
    update_post_meta( $post_id, 'datetime', time() );
    update_post_meta( $post_id, 'discount', $discount );
  }
}
