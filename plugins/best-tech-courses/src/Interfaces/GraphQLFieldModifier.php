<?php
namespace BestTechCourses\Interfaces;

interface GraphQLFieldModifier {
	public function modify( array $fields );
}
