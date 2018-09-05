<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class TaxonomyLabel implements Hookable {

	public function register_hooks() {
		// Hook location: wp-admin/includes/class-walker-category-checklist.php:106
		add_filter( 'the_category', [ $this, 'modify_labels'] );
	}

	public function modify_labels( $label ) {
		if ( ! is_numeric( $label ) ) {
			return $label;
		}

		$post_id = absint( $label );

		return "{$post_id}: " . get_the_title( $post_id );
	}
}
