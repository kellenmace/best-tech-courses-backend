<?php
namespace BestTechCourses\Core;

use BestTechCourses\Interfaces\Hookable;

class ConfirmationStatusTaxonomy extends Taxonomy implements Hookable {

	public function register_hooks() {
		add_action( 'init', [ $this, 'register_taxonomy' ], 11 );
		add_action( 'admin_print_scripts', [ $this, 'limit_to_one_status' ], 20 );
	}

	public function register_taxonomy() {
		register_taxonomy(
			'status',
			'confirmation',
			[
				'labels'            => $this->generate_labels( 'Status', 'Statuses' ),
				'hierarchical'      => true,
				'show_admin_column' => true,
			]
		);
	}

	public function limit_to_one_status() {
		if ( ! $this->should_status_be_limited() ) {
			return;
		}

		?>
		<script type="text/javascript" data-name="newman">
			( function ( $ ) {
				$( document ).ready( function () {

					$( 'body' ).on( 'submit.edit-post', '#post', function () {

						const checkedBoxes = [...document.querySelectorAll('#taxonomy-status input[type="checkbox"]')].filter(input => input.checked);
						const uniqueIds = [...new Set( checkedBoxes.map(input => input.value) )];

						if ( uniqueIds.length < 2 ) return true;

						// Show an alert.
						window.alert('Only one status may be set.');

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

	private function should_status_be_limited() {
		return $this->on_post_create_or_edit_screen() && $this->is_confirmation_post_type();
	}

	private function on_post_create_or_edit_screen() {
		global $pagenow;
		return 'post.php' === $pagenow || 'post-new.php' === $pagenow;
	}

	private function is_confirmation_post_type() {
		return 'confirmation' === get_post_type();
	}
}
