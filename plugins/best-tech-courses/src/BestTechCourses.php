<?php
namespace BestTechCourses;

use BestTechCourses\Model\Course;
use BestTechCourses\Model\AffiliateLinkClick;
use BestTechCourses\Model\Review;
use BestTechCourses\Model\Confirmation;
use BestTechCourses\Model\Payment;
use BestTechCourses\Model\CourseFields;
use BestTechCourses\Model\ReviewFields;
use BestTechCourses\Model\CourseCategoryFields;
use BestTechCourses\Model\CourseCategory;
use BestTechCourses\Model\CourseIdTaxonomy;
use BestTechCourses\Model\UserIdTaxonomy;
use BestTechCourses\Model\ConfirmationStatusTaxonomy;
use BestTechCourses\Model\TaxonomyLabel;
use BestTechCourses\Model\UserFields;
use BestTechCourses\Model\UserEmails;

/**
 * Main plugin class.
 */
final class BestTechCourses {

  public function run() {
    ( new Course() )->register_hooks();
    ( new AffiliateLinkClick() )->register_hooks();
    ( new Review() )->register_hooks();
    ( new Confirmation() )->register_hooks();
    ( new Payment() )->register_hooks();
    ( new CourseFields() )->register_hooks();
    ( new ReviewFields() )->register_hooks();
    ( new CourseCategoryFields() )->register_hooks();
    ( new CourseCategory() )->register_hooks();
    ( new CourseIdTaxonomy() )->register_hooks();
    ( new UserIdTaxonomy() )->register_hooks();
    ( new ConfirmationStatusTaxonomy() )->register_hooks();
    ( new TaxonomyLabel() )->register_hooks();
    ( new UserFields() )->register_hooks();
    ( new UserEmails() )->register_hooks();
  }
}
