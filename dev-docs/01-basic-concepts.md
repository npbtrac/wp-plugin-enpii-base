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

## How Enpii Base works
Enpii Base plugin will split WordPress into 3 modes:
- Normal WordPress workflow
- WP App mode: use Laravel to handle the request and response with Laravel
- WP Api mode: same with WP App but for API only, no HTML rendering

### Normal WordPress workflow
1. All behavious of WordPress must be kept
2. Enpii Base is loaded as a MU plugin (this should be the choice), normal plugin or a dependency of plugins or themes.
3. When Enpii Base plugin loaded, the WP_Application instance would be initialized and the Enpii_Base_WP_Plugin would be initialized next to work as the service provider for WP_Application.
4. At Enpii_Base_WP_Plugin, we created several hooks for WP App based on the WP Hooks:
   1. The const `ENPII_BASE_SETUP_HOOK_NAME` defines the moment when we setup the WP App.
   2. `enpii_base_wp_app_loaded` is the event when the WP App is loaded, we should use this event to register WP Plugins, WP Themes.
   3. `enpii_base_wp_app_registered` is the action happens when the WP App and all service providers registered
   4. `enpii_base_wp_app_booted` is the action happens when the WP App and all service providers are booted
