# Best Tech Courses - Backend
Headless WordPress backend for Best Tech Courses.

## Steps to get up and running:

1. Clone repo as the /wp-content/ directory.
1. Define a `FRONTEND_ORIGIN` constant with the URL to the React frontend app
1. Run `composer install` inside of plugins/best-tech-courses/
1. Activate the `Best Tech Courses - Headless WordPress` theme
1. Activate all plugins

## Info
- `Best Tech Courses` is the core project plugin.
- `Advanced Custom Fields` is used for managing meta fields.
- All WP site data is exposed via WP GraphQL.
- Users are authenticated via JSON Web Tokens and the `WPGraphQL JWT Authentication` plugin.
