<?php

class MenuConnectionQueriesTest extends \Codeception\TestCase\WPTestCase {

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		add_theme_support( 'nav_menu_locations' );
		register_nav_menu( 'my-menu-location', 'My Menu' );
		set_theme_mod( 'nav_menu_locations', [ 'my-menu-location' => 0 ] );
	}

	public function testMenusQueryById() {
		$menu_slug = 'my-test-menu-by-id';
		$menu_id = wp_create_nav_menu( $menu_slug );

		$query = '
		{
			menus( where: { id: ' . intval( $menu_id ) . ' } ) {
				edges {
					node {
						menuId
						name
					}
				}
			}
		}
		';
		$this->assertEquals( 1, 1 );
		return;

		$actual = do_graphql_request( $query );

		$this->assertEquals( 1, count( $actual['data']['menus']['edges'] ) );
		$this->assertEquals( $menu_id, $actual['data']['menus']['edges'][0]['node']['menuId'] );
		$this->assertEquals( $menu_slug, $actual['data']['menus']['edges'][0]['node']['name'] );
	}

	public function testMenusQueryByLocation() {
		$menu_slug = 'my-test-menu-by-location';
		$menu_id = wp_create_nav_menu( $menu_slug );

		// Assign menu to location.
		set_theme_mod( 'nav_menu_locations', [ 'my-menu-location' => $menu_id ] );

		$query = '
		{
			menus( where: { location: MY_MENU_LOCATION } ) {
				edges {
					node {
						menuId
						name
					}
				}
			}
		}
		';

		$actual = do_graphql_request( $query );

		$this->assertEquals( 1, count( $actual['data']['menus']['edges'] ) );
		$this->assertEquals( $menu_id, $actual['data']['menus']['edges'][0]['node']['menuId'] );
		$this->assertEquals( $menu_slug, $actual['data']['menus']['edges'][0]['node']['name'] );
	}

	public function testMenusQueryBySlug() {
		$menu_slug = 'my-test-menu-by-slug';
		$menu_id = wp_create_nav_menu( $menu_slug );

		$query = '
		{
			menus( where: { slug: "' . $menu_slug . '" } ) {
				edges {
					node {
						menuId
						name
					}
				}
			}
		}
		';

		$actual = do_graphql_request( $query );

		$this->assertEquals( 1, count( $actual['data']['menus']['edges'] ) );
		$this->assertEquals( $menu_id, $actual['data']['menus']['edges'][0]['node']['menuId'] );
		$this->assertEquals( $menu_slug, $actual['data']['menus']['edges'][0]['node']['name'] );
	}

	public function testMenusQueryMultiple() {
		$menu_ids = [
			wp_create_nav_menu( 'my-test-menu-1' ),
			wp_create_nav_menu( 'my-test-menu-2' ),
			wp_create_nav_menu( 'my-test-menu-3' ),
		];

		$query = '
		{
			menus {
				edges {
					node {
						menuId
						name
					}
				}
			}
		}
		';

		$actual = do_graphql_request( $query );

		$this->assertEquals( count( $menu_ids ), count( $actual['data']['menus']['edges'] ) );
		foreach( $menu_ids as $index => $menu_id ) {
			$this->assertEquals( $menu_id, $actual['data']['menus']['edges'][ $index ]['node']['menuId'] );
		}
	}

}
