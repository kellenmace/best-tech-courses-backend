<?php
namespace BestTechCourses\CustomPostTypes;

use BestTechCourses\Interfaces\Hookable;

abstract class CustomPostType implements Hookable {

	protected $slug;

	public function __construct( $slug ) {
		$this->slug = $slug;
	}

	public function get_slug() {
		return $this->slug;
	}

	abstract public function register();

	protected function generate_labels( $singular, $plural ) {
		return [
			'name'                  => _x( $plural, 'post type general name', 'best-tech-courses' ),
			'singular_name'         => _x( $singular, 'post type singular name', 'best-tech-courses' ),
			'menu_name'             => _x( $plural, 'admin menu', 'best-tech-courses' ),
			'name_admin_bar'        => _x( $singular, 'add new on admin bar', 'best-tech-courses' ),
			'add_new'               => _x( 'Add New', $singular, 'best-tech-courses' ),
			'add_new_item'          => sprintf( __( 'Add New %s', 'best-tech-courses' ), $singular ),
			'new_item'              => sprintf( __( 'New %s', 'best-tech-courses' ), $singular ),
			'edit_item'             => sprintf( __( 'Edit %s', 'best-tech-courses' ), $singular ),
			'view_item'             => sprintf( __( 'View %s', 'best-tech-courses' ), $singular ),
			'all_items'             => sprintf( __( 'All %s', 'best-tech-courses' ), $plural ),
			'search_items'          => sprintf( __( 'Search %s', 'best-tech-courses' ), $plural ),
			'parent_item_colon'     => sprintf( __( 'Parent %s:', 'best-tech-courses' ), $plural ),
			'not_found'             => sprintf( __( 'No %s found.', 'best-tech-courses' ), strtolower( $plural ) ),
			'not_found_in_trash'    => sprintf( __( 'No %s found in Trash.', 'best-tech-courses' ), strtolower( $plural ) ),
			'featured_image'        => sprintf( __( '%s Image.', 'best-tech-courses' ), $singular ),
			'set_featured_image'    => sprintf( __( 'Set %s image.', 'best-tech-courses' ), strtolower( $singular  ) ),
			'remove_featured_image' => sprintf( __( 'Remove %s image.', 'best-tech-courses' ), strtolower( $singular  ) ),
			'use_featured_image'    => sprintf( __( 'Use as %s image.', 'best-tech-courses' ), strtolower( $singular  ) ),
		];
	}
}
