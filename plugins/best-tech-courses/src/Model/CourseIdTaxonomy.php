<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class CourseIdTaxonomy extends Taxonomy implements Hookable {

	private static $post_types = [ 'affiliate_link_click', 'review', 'confirmation' ];

	public function register_hooks() {
		add_action( 'init', [ $this, 'register_taxonomy' ], 11 );
		add_action( 'admin_print_scripts', [ $this, 'require_course_id' ], 20 );
	}

	public function register_taxonomy() {
		register_taxonomy(
			'course_id',
			self::$post_types,
			[
				'labels'              => $this->generate_labels( 'Course ID', 'Course ID' ),
				'hierarchical'        => true,
				'show_in_graphql'     => true,
				'show_admin_column'   => true,
				'graphql_single_name' => 'courseId',
				'graphql_plural_name' => 'courseIds',
			]
		);
	}

	public function require_course_id() {
		if ( ! $this->should_course_id_be_required() ) {
			return;
		}

		?>
		<script type="text/javascript" data-name="newman">
			( function ( $ ) {
				$( document ).ready( function () {

					$( 'body' ).on( 'submit.edit-post', '#post', function () {

						const checkedBoxes = [...document.querySelectorAll('#taxonomy-course_id input[type="checkbox"]')].filter(input => input.checked);
						const uniqueIds = [...new Set( checkedBoxes.map(input => input.value) )];

						if ( 1 === uniqueIds.length ) return true;

						// Show an alert.
						if ( 0 === uniqueIds.length ) {
							window.alert('A Course ID is required.');
						} else {
							window.alert('Only one Course ID may be set.');
						}

						// Hide the spinner.
						$( '#major-publishing-actions .spinner' ).hide();

						// The buttons get "disabled" added to them on submit. Remove that class.
						$( '#major-publishing-actions' ).find( ':button, :submit, a.submitdelete, #post-preview' ).removeClass( 'disabled' );

						return false;
					});
				});
			}( window.jQuery ) );
		</script>
		<?php
	}

	private function should_course_id_be_required() {
		return $this->on_post_create_or_edit_screen() && $this->does_post_type_require_course_id();
	}

	private function on_post_create_or_edit_screen() {
		global $pagenow;
		return 'post.php' === $pagenow || 'post-new.php' === $pagenow;
	}

	private function does_post_type_require_course_id() {
		return in_array( get_post_type(), self::$post_types, true );
	}
}
