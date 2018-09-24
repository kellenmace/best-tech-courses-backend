<?php
namespace BestTechCourses\Admin;

use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\Taxonomies\ConfirmationStatus;
use BestTechCourses\Taxonomies\CourseId;
use BestTechCourses\Taxonomies\UserId;
use function BestTechCourses\get_plugin_url;
use function BestTechCourses\get_plugin_dir;

class AssetLoader implements Hookable {

	private $confirmation_status;

	private $course_id;

	private $user_id;

	public function __construct( ConfirmationStatus $confirmation_status, CourseId $course_id, UserId $user_id ) {
		$this->confirmation_status = $confirmation_status;
		$this->course_id           = $course_id;
		$this->user_id             = $user_id;
	}

	public function register_hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public function enqueue_scripts() {
		if ( ! $this->on_post_create_or_edit_screen() ) {
			return;
		}

		$handle = 'btc-require-terms';
		$path   = 'assets/js/require-terms.js';

		wp_enqueue_script(
			$handle,
			get_plugin_url() . $path,
			[ 'jquery' ],
			filemtime( get_plugin_dir() . $path )
		);

		wp_localize_script(
			$handle,
			'btcRequireTermsData',
			[
				'currentPostType'    => get_post_type(),
				'confirmationStatus' => [
					'slug'      => $this->confirmation_status->get_slug(),
					'postTypes' => $this->confirmation_status->get_post_type_slugs(),
				],
				'courseId'           => [
					'slug'      => $this->course_id->get_slug(),
					'postTypes' => $this->course_id->get_post_type_slugs(),
				],
				'userId'             => [
					'slug'      => $this->user_id->get_slug(),
					'postTypes' => $this->user_id->get_post_type_slugs(),
				],
			]
		);
	}

	private function on_post_create_or_edit_screen() {
		global $pagenow;
		return 'post.php' === $pagenow || 'post-new.php' === $pagenow;
	}
}