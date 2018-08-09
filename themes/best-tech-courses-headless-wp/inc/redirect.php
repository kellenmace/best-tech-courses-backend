<?php

/*
 *  In the event that a request comes in to the headless WP site, redirect it to the frontend site.
 */
add_action( 'template_redirect', function() {
	wp_redirect( untrailingslashit( get_frontend_origin() ) . $_SERVER[REQUEST_URI] );
} );
