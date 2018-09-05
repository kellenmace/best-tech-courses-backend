<?php

/**
 * Get the frontend origin URL.
 *
 * @return string Frontend origin URL, i.e., http://localhost:3000 or https://besttechcourses.io/
 */
function get_frontend_origin() {
	return defined( 'FRONTEND_ORIGIN' ) && FRONTEND_ORIGIN ? FRONTEND_ORIGIN : '';
}
