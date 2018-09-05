<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class UserIdTaxonomy extends Taxonomy implements Hookable {

	public function register_hooks() {
		add_action( 'init', [ $this, 'register_taxonomy' ], 11 );
		add_action( 'admin_print_scripts', [ $this, 'require_user_id' ], 20 );
		add_action( 'show_user_profile', [ $this, 'display_user_id_on_profile' ] );
		add_action( 'edit_user_profile', [ $this, 'display_user_id_on_profile' ] );
	}

	public function register_taxonomy_TEST() {
		register_taxonomy(
			'profession',
			'course',
			array(
			'public'        =>true,
			'single_value' => false,
			'show_admin_column' => true,
			'show_in_graphql'     => true,
			'graphql_single_name' => 'userId',
			'graphql_plural_name' => 'userIds',
			'labels'        =>array(
				'name'                      =>'Professions',
				'singular_name'             =>'Profession',
				'menu_name'                 =>'Professions',
				'search_items'              =>'Search Professions',
				'popular_items'             =>'Popular Professions',
				'all_items'                 =>'All Professions',
				'edit_item'                 =>'Edit Profession',
				'update_item'               =>'Update Profession',
				'add_new_item'              =>'Add New Profession',
				'new_item_name'             =>'New Profession Name',
				'separate_items_with_commas'=>'Separate professions with commas',
				'add_or_remove_items'       =>'Add or remove professions',
				'choose_from_most_used'     =>'Choose from the most popular professions',
			),
			'rewrite'       =>array(
				'with_front'                =>true,
				'slug'                      =>'author/profession',
			),
			'capabilities'  => array(
				'manage_terms'              =>'edit_users',
				'edit_terms'                =>'edit_users',
				'delete_terms'              =>'edit_users',
				'assign_terms'              =>'read',
			),
		));
	}

	public function register_taxonomy() {
		register_taxonomy(
			'user_id',
			[ 'user', 'affiliate_link_click', 'review', 'confirmation', 'payment' ],
			[
				'labels'              => $this->generate_labels( 'User ID', 'User ID' ),
				'hierarchical'        => true,
				'show_admin_column'   => true,
				'single_value'        => true,
				'show_in_graphql'     => true,
				'graphql_single_name' => 'userId',
				'graphql_plural_name' => 'userIds',
				'update_count_callback' => 'km_user_taxonomies_update_count'
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
		return in_array( get_post_type(), [ 'affiliate_link_click', 'review', 'confirmation', 'payment' ], true );
	}

	public function display_user_id_on_profile( $user ) {
		?>
		<table class="form-table">
			<tbody>
				<tr class="acf-field">
					<td class="acf-label">
						<label for="user-id-term">User ID</label>
					</td>
					<td class="acf-input">
						<div class="acf-input-wrap">
							<input
								type="text"
								id="user-id-term"
								name="user-id-term"
								value="<?php echo esc_html( $this->get_user_id_term_name( $user ) ); ?>"
								disabled
							/>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	private function get_user_id_term_name( $user ) {
		$user_ids = wp_get_object_terms( $user->ID, 'user_id' );
		return $user_ids && is_array( $user_ids ) ? $user_ids[0]->name : '';
	}
}
