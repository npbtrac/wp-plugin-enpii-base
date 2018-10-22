### Introduction
- Since I needed to do a lot of WordPress projects and they have same formula so I decide to create this plugin as a base plugin for all of my WordPress development.
- This plugin works as a composer package only (so you may need to use Bedrock WordPress for it) and requires Advanced Custom Fields Pro plugin to work.
- It uses **bower** to manage client-side resources.
- Aura Dependency Injection [http://auraphp.com/packages/2.x/Di.html](http://auraphp.com/packages/2.x/Di.html) from AuraPHP for managing dependencies and lazy loading component/service (meaning files included only when component/service invoked, this helps to keep good performance on application like current modern frameworks).

### Installation
- ```composer install``` to install all dependencies

### Basic ideas
- It uses a singleton ```WebApp::instance()``` instance that accessible anywhere. Before using this singleton instance, you need to initialize it ```WebApp::initialize($config);``` where `$config` is an array.
- Base namespace `Enpii\Wp\EnpiiBase`, where first segment is my team, second is platform name and third is project name.
- Format of the config array is like following
```php
$config = [
    // ID of the theme, this ID will be added to body class, it will be useful when you have child theme and want to style it particularly
	'id' => 'theme-id',
	
	// Components to use
	'components' => [
	    // WP Theme object for theme development. It should be Enpii\Wp\EnpiiBase\Component\WpTheme instance, class name is the 
	    // Item key is the name of the component
	    // Component can be invoked by using ```WebApp::instance()->componennt_name```
	    // Item value is array of initial params to be assigned to object of the class specified by array key `class` 
		'wp_theme' => [
		    // Class name to be used for WpTheme Object
			'class' => OverrideNamespace\WpTheme::class,
			// Version of theme
			'version' => '0.21',
			
			// text_domain to use for the theme
			'text_domain' => 'some_text_domain',
			
			// Use custom client resources by CDN or locally, usually for development, is us local resources for faster loading
			'use_cdn' => WP_DEBUG ? false : true,
			
			// server path & url to the theme, this is for parent theme in case child theme using. 
			'base_path' => get_template_directory(),
			'base_url' => get_template_directory_uri(),

			// only set when child theme using
			'child_base_path' => get_template_directory() === get_stylesheet_directory() ? null : get_stylesheet_directory(),
			'child_base_url' => get_template_directory_uri() === get_stylesheet_directory_uri() ? null : get_stylesheet_directory_uri(),

            // HTML Helper service to be used
			'html_helper' => 'html_helper',
		],
		
		// Component HTML Helper, give you library to creat html tags (anchor, radio, select ...) faster
		// \Enpii\Wp\EnpiiBase\Component\HtmlHelper should be used
		'html_helper' => [
			'class' => \Enpii\Wp\EnpiiBase\Component\HtmlHelper::class,
			
			// All these params defined by https://packagist.org/packages/snscripts/html-helper 
			'form_class' => \Snscripts\HtmlHelper\Helpers\Form::class,
			'basic_form_interface' => \Snscripts\HtmlHelper\Interfaces\BasicFormData::class,
			'basic_router_interface' => \Snscripts\HtmlHelper\Interfaces\BasicRouter::class,
			'basic_assets_interface' => \Snscripts\HtmlHelper\Interfaces\BasicAssets::class,
		],
	],
];
```
- Provide quick way to register popular client side asset like **font-awesome, bxslider, isotop, modernizr** ... to application (using local or via CDN assets)

### Usages
- ```WpApp::load_config($config);``` to init the singleton instance
- ```WpApp::instance()->wp_theme``` to get the component WpTheme to create your theme. Hooks created using ```WpApp::instance()->componennt_name->method_name()``` can be de-registered, e.g ```remove_action( $tag, [WpApp::instance()->componennt_name, 'method_name'])```
- For theme development
    + Configs are in **enpii-config.php**, on child theme or parent theme. These config files loaded autobatically by plugins when theme in use.
    + Just put following snippets to your **functions.php**
```php
use Enpii\Wp\EnpiiBase\Base\WpApp as WpApp;

// Below line is for PHP Storm to understand the component class 
/* @var Enpii\Wp\EnpiiBase\Component\WpTheme $wp_theme */
$wp_theme = WpApp::instance()->wp_theme;
$wp_theme->initialize();
```