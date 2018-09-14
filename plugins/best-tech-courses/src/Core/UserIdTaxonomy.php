<?php
namespace BestTechCourses\Core;

use BestTechCourses\Interfaces\Hookable;

class UserIdTaxonomy extends Taxonomy implements Hookable {

	private static $post_types = [ 'affiliate_link_click', 'review', 'confirmation', 'payment' ];

	public function register_hooks() {
		add_action( 'init',                [ $this, 'register_taxonomy' ], 11 );
		add_action( 'admin_print_scripts', [ $this, 'require_user_id' ], 20 );
	}

	public function register_taxonomy() {
		register_taxonomy(
			'user_id',
			self::$post_types,
			[
				'labels'              => $this->generate_labels( 'User ID', 'User ID' ),
				'hierarchical'        => true,
				'show_admin_column'   => true,
				'single_value'        => true,
				'show_in_graphql'     => true,
				'graphql_single_name' => 'userId',
				'graphql_plural_name' => 'userIds',
			]
		);
	}

	public function require_user_id() {
		if ( ! $this->should_user_id_be_required() ) {
			return;
		}

		?>
		<script type="text/javascript" data-name="newman">
			( function ( $ ) {
				$( document ).ready( function () {

					$( 'body' ).on( 'submit.edit-post', '#post', function () {

						const checkedBoxes = [...document.querySelectorAll('#taxonomy-user_id input[type="checkbox"]')].filter(input => input.checked);
						const uniqueIds = [...new Set( checkedBoxes.map(input => input.value) )];

						if ( 1 === uniqueIds.length ) return true;

						// Show an alert.
						if ( 0 === uniqueIds.length ) {
							window.alert('A User ID is required.');
						} else {
							window.alert('Only one User ID may be set.');
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

	private function should_user_id_be_required() {
		return $this->on_post_create_or_edit_screen() && $this->does_post_type_require_user_id();
	}

	private function on_post_create_or_edit_screen() {
		global $pagenow;
		return 'post.php' === $pagenow || 'post-new.php' === $pagenow;
	}

	private function does_post_type_require_user_id() {
		return in_array( get_post_type(), self::$post_types, true );
	}
}
