<?php
namespace BestTechCourses;

use BestTechCourses\Admin;
use BestTechCourses\Controllers;
use BestTechCourses\CustomPostTypes;
use BestTechCourses\Interfaces\Hookable;
use BestTechCourses\Taxonomies;
use BestTechCourses\Users;

/**
 * Main plugin class.
 */
final class BestTechCourses {

	private $objects = [];

	public function run() {
		$this->instantiate_user_classes();
		$this->instantiate_cpt_classes();
		$this->instantiate_cpt_field_classes();
		$this->instantiate_taxonomy_classes();
		$this->instantiate_taxonomy_field_classes();
		$this->instantiate_controller_classes();
		$this->instantiate_admin_classes();
		$this->register_hooks();
	}

	private function instantiate_user_classes() {
		$this->objects['User']            = new Users\User();
		$this->objects['UserEmails']      = new Users\UserEmails();
		$this->objects['UserInputFields'] = new Users\UserInputFields();
	}

	private function instantiate_cpt_classes() {
		$this->objects['AffiliateLinkClick'] = new CustomPostTypes\AffiliateLinkClick();
		$this->objects['Confirmation']       = new CustomPostTypes\Confirmation();
		$this->objects['Course']             = new CustomPostTypes\Course();
		$this->objects['Payment']            = new CustomPostTypes\Payment();
		$this->objects['Review']             = new CustomPostTypes\Review();
	}

	private function instantiate_cpt_field_classes() {
		$this->objects['CourseFields'] = new CustomPostTypes\CourseFields( $this->objects['Course'] );
	}

	private function instantiate_taxonomy_classes() {
		$this->objects['ConfirmationStatus'] = new Taxonomies\ConfirmationStatus( [ $this->objects['Confirmation'] ] );
		$this->objects['CourseCategory']     = new Taxonomies\CourseCategory( [ $this->objects['Course'] ] );
		$this->objects['CourseId']           = new Taxonomies\CourseId( [
			$this->objects['AffiliateLinkClick'],
			$this->objects['Confirmation'],
			$this->objects['Payment']
		] );
		$this->objects['UserId']             = new Taxonomies\UserId( [
			$this->objects['AffiliateLinkClick'],
			$this->objects['Confirmation'],
			$this->objects['Payment'],
			$this->objects['Review']
		] );
	}

	private function instantiate_taxonomy_field_classes() {
		$this->objects['CourseCategoryFields'] = new Taxonomies\CourseCategoryFields( $this->objects['CourseCategory'] );
	}

	private function instantiate_controller_classes() {
		$this->objects['PostDataUtilities']            = new Controllers\PostDataUtilities();
		$this->objects['AffiliateLinkClickController'] = new Controllers\AffiliateLinkClickController(
			$this->objects['AffiliateLinkClick'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['ConfirmationController']       = new Controllers\ConfirmationController(
			$this->objects['Confirmation'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['PaymentController']            = new Controllers\PaymentController(
			$this->objects['Payment'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['ReviewController']             = new Controllers\ReviewController(
			$this->objects['Review'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['UserController']               = new Controllers\UserController();
	}

	private function instantiate_admin_classes() {
		$this->objects['AffiliateLinkClickAdminColumns'] = new Admin\AffiliateLinkClickAdminColumns(
			$this->objects['AffiliateLinkClick'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['ConfirmationAdminColumns']       = new Admin\ConfirmationAdminColumns(
			$this->objects['Confirmation'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['CourseAdminColumns']             = new Admin\CourseAdminColumns(
			$this->objects['Course'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['PaymentAdminColumns']            = new Admin\PaymentAdminColumns(
			$this->objects['Payment'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['ReviewAdminColumns']             = new Admin\ReviewAdminColumns(
			$this->objects['Review'],
			$this->objects['PostDataUtilities']
		);
		$this->objects['AssetLoader']                    = new Admin\AssetLoader(
			$this->objects['ConfirmationStatus'],
			$this->objects['CourseId'],
			$this->objects['UserId']
		);
	}

	private function register_hooks() {
		foreach ( $this->objects as $object ) {
			if ( ! $object instanceof Hookable ) {
				continue;
			}

			$object->register_hooks();
		}
	}
}
