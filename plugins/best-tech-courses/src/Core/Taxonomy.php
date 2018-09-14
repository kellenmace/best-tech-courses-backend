<?php
namespace BestTechCourses\Core;

abstract class Taxonomy {

  abstract public function register_taxonomy();

  protected function generate_labels( $singular, $plural ) {
    return [
      'name'              => _x( $plural, 'taxonomy general name', 'best-tech-courses' ),
      'singular_name'     => _x( $singular, 'taxonomy singular name', 'best-tech-courses' ),
      'search_items'      => __( "Search {$plural}", 'best-tech-courses' ),
      'all_items'         => __( "All {$plural}", 'best-tech-courses' ),
      'parent_item'       => __( "Parent {$singular}", 'best-tech-courses' ),
      'parent_item_colon' => __( "Parent {$singular}:", 'best-tech-courses' ),
      'edit_item'         => __( "Edit {$singular}", 'best-tech-courses' ),
      'update_item'       => __( "Update {$singular}", 'best-tech-courses' ),
      'add_new_item'      => __( "Add New {$singular}", 'best-tech-courses' ),
      'new_item_name'     => __( "New {$singular} Name", 'best-tech-courses' ),
      'menu_name'         => __( $plural, 'best-tech-courses' ),
    ];
  }
}
