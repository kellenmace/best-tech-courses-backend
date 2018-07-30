<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

abstract class AbstractGraphQL implements Hookable, GraphQL {

  protected function get_custom_field_callback( $slug, $escaping_cb ) {
    return function( \WP_Post $post ) use ( $slug, $escaping_cb ) {
      $value = get_post_meta( $post->ID, $slug, true );
      return ! empty( $value ) ? $escaping_cb( $value ) : null;
    };
  }
}
