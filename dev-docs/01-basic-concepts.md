## Base concepts
- This plugin will create a laravel application `wp_app()` (a DI container https://code.tutsplus.com/tutorials/digging-in-to-laravels-ioc-container--cms-22167) contains everything we need.
- Each plugin or theme will act as a Service Provider https://laravel.com/docs/7.x/providers
- All Laravel Base Providers are loaded in WP_Application (similar to Applications)
- Main Service Providers (Configured Service Providers) should be loaded when Kernel do the bootstrapping all bootstrappers
- We don't load the configuration from the file so we skip the LoadConfiguration bootstrapper, and LoadEnvironmentVariables should be skipped as well as we don't need WP_Application to load environment variables from .env files
- On each Service Provider, we should put the configs for that Service Provider to the 'config' instance of the application to avoid a big array. Each should come with a filter to allow other plugins to tweak the configs.
- WP Application bootstapping happens at the action `after_setup_theme`, to have the theme `functions.php` loaded as well. The theme functions.php is loaed right before the action `after_setup_theme` happens.
- `wp_app()` (helper function for getting `WP_Application::$instance`) needs to skip the WordPress template render and skip the main query when the URL is working on **wp_app mode** (domain.com/wp-app)
- **wp_app()** should skip the WordPress rest api as well on **wp_api mode** (domain.com/wp-api)
