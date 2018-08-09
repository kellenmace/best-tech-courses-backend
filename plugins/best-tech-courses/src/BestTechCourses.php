<?php
namespace BestTechCourses;

use BestTechCourses\Model\CustomPostTypes;
use BestTechCourses\Model\CourseFields;
use BestTechCourses\Model\ReviewFields;
use BestTechCourses\Model\CourseCategoryFields;
use BestTechCourses\Model\Taxonomies;
use BestTechCourses\Model\UserFields;

/**
 * Main plugin class.
 */
final class BestTechCourses {

  public function run() {
    ( new CustomPostTypes() )->register_hooks();
    ( new CourseFields() )->register_hooks();
    ( new ReviewFields() )->register_hooks();
    ( new CourseCategoryFields() )->register_hooks();
    ( new Taxonomies() )->register_hooks();
    ( new UserFields() )->register_hooks();
  }
}
