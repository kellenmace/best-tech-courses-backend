<?php
namespace BestTechCourses\Core;

abstract class Taxonomy {

  abstract public function register_taxonomy();

  protected function generate_labels( $singular, $plural ) {
    return [
      'name'              => _x( $plural, 'taxonomy general name', 'best-tech-courses' ),
      'singular_name'     => _x( $singular, 'taxonomy singular name', 'best-tech-courses' ),
      'search_items'      => sprintf( __( 'Search %s', 'best-tech-courses' ), $plural ),
      'all_items'         => sprintf( __( 'All %s', 'best-tech-courses' ), $plural ),
      'parent_item'       => sprintf( __( 'Parent %s', 'best-tech-courses' ), $singular ),
      'parent_item_colon' => sprintf( __( 'Parent %s:', 'best-tech-courses' ), $singular ),
      'edit_item'         => sprintf( __( 'Edit %s:', 'best-tech-courses' ), $singular ),
      'update_item'       => sprintf( __( 'Update %s:', 'best-tech-courses' ), $singular ),
      'add_new_item'      => sprintf( __( 'Add New %s:', 'best-tech-courses' ), $singular ),
      'new_item_name'     => sprintf( __( 'New %s Name', 'best-tech-courses' ), $singular ),
      'menu_name'         => $plural,
    ];
  }
}
