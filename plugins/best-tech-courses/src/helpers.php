<?php
namespace BestTechCourses;

/**
 * Prefix a hook with our custom namespace.
 *
 * This function will take our plugin's namespace and use it as the prefix for a hook.
 * e.g., BestTechCourses\connection_status_changed
 *
 * @param string $hook Name of the hook.
 *
 * @return string
 */
function prefix_hook( string $hook ) {
	return MigrationsFramework::HOOK_PREFIX . $hook;
}
