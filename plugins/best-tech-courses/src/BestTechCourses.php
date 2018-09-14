<?php
namespace BestTechCourses;

use BestTechCourses\Core\Course;
use BestTechCourses\Core\AffiliateLinkClick;
use BestTechCourses\Core\Review;
use BestTechCourses\Core\Confirmation;
use BestTechCourses\Core\Payment;
use BestTechCourses\Core\CourseFields;
use BestTechCourses\Core\ReviewFields;
use BestTechCourses\Core\AffiliateLinkClickFields;
use BestTechCourses\Core\CourseCategoryFields;
use BestTechCourses\Core\CourseCategory;
use BestTechCourses\Core\CourseIdTaxonomy;
use BestTechCourses\Core\UserIdTaxonomy;
use BestTechCourses\Core\ConfirmationStatusTaxonomy;
use BestTechCourses\Core\TaxonomyLabel;
use BestTechCourses\Core\UserFields;
use BestTechCourses\Core\UserEmails;

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
    ( new AffiliateLinkClickFields() )->register_hooks();
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
