<?php

/**
 * Get the frontend origin URL.
 *
 * @return str Frontend origin URL, i.e., http://localhost:3000.
 */
function get_frontend_origin() {
    return defined( 'FRONTEND_ORIGIN' ) && FRONTEND_ORIGIN ? FRONTEND_ORIGIN : '';
}
