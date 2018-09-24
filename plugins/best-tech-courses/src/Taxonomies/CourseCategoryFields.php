<?php
namespace BestTechCourses\Taxonomies;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\Interfaces\GraphQLFieldModifier;
use WPGraphQL\Types;

class CourseCategoryFields implements Hookable, GraphQLFieldModifier {

    private $course_category;

    public function __construct( CourseCategory $course_category ) {
        $this->course_category = $course_category;
    }

    public function register_hooks() {
        add_filter( "graphql_{$this->course_category->get_graphql_single_name()}_fields", [ $this, 'modify' ] );
    }

    public function modify( array $fields ) {
        $fields['imageUrl'] = [
            'type'        => Types::string(),
            'description' => __( 'SVG image URL', 'best-tech-courses' ),
            'resolve'     => function ( \WP_Term $term ) {
                $image = get_field( 'image', $term );

                return $image && is_array( $image ) ? $image['url'] : '';
            },
        ];

        return $fields;
    }
}
