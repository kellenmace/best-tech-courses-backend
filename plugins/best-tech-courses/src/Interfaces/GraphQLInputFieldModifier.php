<?php
namespace BestTechCourses\Interfaces;

interface GraphQLInputFieldModifier {
	public function modify( array $input_fields );
}
