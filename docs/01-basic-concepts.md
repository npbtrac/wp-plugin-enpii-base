## Base concepts
- This plugin will create a laravel application `wp_app()` (a DI container https://code.tutsplus.com/tutorials/digging-in-to-laravels-ioc-container--cms-22167) contains everything we need.
- Each plugin or theme will act as a Service Provider https://laravel.com/docs/7.x/providers
- All Laravel Base Providers are loaded in WP_Application (similar to Applications)
- Main Service Providers (Configured Service Providers) should be loaded when Kernel do the bootstrapping all bootstrappers
- We don't load the configuration from the file so we skip the LoadConfiguration bootstrapper
- On each Service Provider, we should put the configs for that Service Provider to the 'config' instance of the application to avoid a big array. Each should come with a filter to allow other plugins to tweak the configs.
- WP Application bootstapping happens at the action `after_setup_theme`, to have the theme `functions.php` loaded as well. The theme functions.php is loaed right before the action `after_setup_theme` happens.
