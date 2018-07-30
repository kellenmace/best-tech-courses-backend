<?php
namespace BestTechCourses\Utilities;

/**
 * Interface Hookable
 */
interface Hookable {
	/**
	 * Register hooks with WordPress.
	 *
	 * @return void
	 */
	public function register_hooks();
}
