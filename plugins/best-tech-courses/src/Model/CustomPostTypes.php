<?php
namespace BestTechCourses\Model;

use BestTechCourses\Utilities\Hookable;

class CustomPostTypes implements Hookable {

  public function register_hooks() {
    add_action( 'init', [ $this, 'register_cpts' ] );
  }

  public function register_cpts() {
    register_post_type( 'course', [
      'labels'              => $this->generate_labels( 'Course', 'Courses' ),
      'public'              => true,
      'menu_position'       => 26,
      'menu_icon'           => 'dashicons-format-video',
      'supports'            => [ 'title', 'editor', 'thumbnail' ],
      'show_in_graphql'     => true,
      'graphql_single_name' => 'course',
      'graphql_plural_name' => 'courses',
    ] );
    
    register_post_type( 'affiliate_link_click', [
      'labels'              => $this->generate_labels( 'Affiliate Link Click', 'Affiliate Link Clicks' ),
      'public'              => true,
      'menu_position'       => 27,
      'menu_icon'           => 'dashicons-migrate',
      'supports'            => false,
      'show_in_graphql'     => true,
      'graphql_single_name' => 'affiliateLinkClick',
      'graphql_plural_name' => 'affiliateLinkClicks',
    ] );

    register_post_type( 'review', [
      'labels'              => $this->generate_labels( 'Review', 'Reviews' ),
      'public'              => true,
      'menu_position'       => 28,
      'menu_icon'           => 'dashicons-thumbs-up',
      'supports'            => [ 'title', 'editor' ],
      'show_in_graphql'     => true,
      'graphql_single_name' => 'review',
      'graphql_plural_name' => 'reviews',
    ] );

    register_post_type( 'confirmation', [
      'labels'        => $this->generate_labels( 'Confirmation', 'Confirmations' ),
      'public'        => true,
      'menu_position' => 29,
      'menu_icon'     => 'dashicons-yes',
      'supports'      => false,
    ] );

    register_post_type( 'payment', [
      'labels'        => $this->generate_labels( 'Payment', 'Payments' ),
      'public'        => true,
      'menu_position' => 30,
      'menu_icon'     => 'dashicons-tickets-alt',
      'supports'      => false,
    ] );
  }

  private function generate_labels( $singular, $plural ) {
    return [
      'name'               => _x( $plural, 'post type general name', 'best-tech-courses' ),
      'singular_name'      => _x( $singular, 'post type singular name', 'best-tech-courses' ),
      'menu_name'          => _x( $plural, 'admin menu', 'best-tech-courses' ),
      'name_admin_bar'     => _x( $singular, 'add new on admin bar', 'best-tech-courses' ),
      'add_new'            => _x( 'Add New', $singular, 'best-tech-courses' ),
      'add_new_item'       => __( "Add New {$singular}", 'best-tech-courses' ),
      'new_item'           => __( "New {$singular}", 'best-tech-courses' ),
      'edit_item'          => __( "Edit {$singular}", 'best-tech-courses' ),
      'view_item'          => __( "View {$singular}", 'best-tech-courses' ),
      'all_items'          => __( "All {$plural}", 'best-tech-courses' ),
      'search_items'       => __( "Search {$plural}", 'best-tech-courses' ),
      'parent_item_colon'  => __( "Parent {$plural}:", 'best-tech-courses' ),
      'not_found'          => __( "No {$plural} found.", 'best-tech-courses' ),
      'not_found_in_trash' => __( "No {$plural} found in Trash.", 'best-tech-courses' )
    ];
  }
}
