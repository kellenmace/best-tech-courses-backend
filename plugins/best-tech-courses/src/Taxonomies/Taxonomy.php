<?php
namespace BestTechCourses\Taxonomies;

use BestTechCourses\CustomPostTypes\CustomPostType;
use BestTechCourses\Interfaces\Hookable;

abstract class Taxonomy implements Hookable {

	protected $slug;

	protected $post_types;

	public function __construct( $slug, array $post_types ) {
		$this->slug       = $slug;
		$this->post_types = $post_types;
	}

	public function get_slug() {
		return $this->slug;
	}

	public function get_post_types() {
		return $this->post_types;
	}

	public function get_post_type_slugs() {
		return array_reduce( $this->post_types, function( $post_type_slugs, CustomPostType $post_type ) {
			$post_type_slugs[] = $post_type->get_slug();
			return $post_type_slugs;
		}, [] );
	}

	abstract public function register();

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
