<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class CourseCategoryFields implements Hookable {

  public function register_hooks() {
    add_filter( 'graphql_CourseCategory_fields', [ $this, 'expose_custom_fields'] );
  }

  public function expose_custom_fields( $fields ) {
    $fields['imageUrl'] = [
        'type'        => \WPGraphQL\Types::string(),
        'description' => __( 'SVG image URL', 'best-tech-courses' ),
        'resolve'     => function( \WP_Term $term ) {
          $image = get_field('image', $term);

          if ( ! is_array( $image ) || ! $image ) {
            return '';
          }

          return $image['url'];
        },
    ];

    return $fields;
  }
}
