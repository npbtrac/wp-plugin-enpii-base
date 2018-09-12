###Introduction
- Since I needed to do a lot of WordPress projects and they have same formula so I decide to create this plugin as a base plugin for all of my WordPress development.
- This plugin works as a composer package only (so you may need to use Bedrock WordPress for it) and requires Advanced Custom Fields Pro plugin to work.

###Basic ideas
- It uses a singleton ```WebApp::instance()``` instance that accessible anywhere. Before using this singleton instance, you need to initialize it ```WebApp::initialize($config);``` where `$config` is an array.
- Base namespace `Enpii\Wp\EnpiiBase`, where first segment is my team, second is platform name and third is project name.
- Format of the config array is like following
```$xslt
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

###Usages
- ```WebApp::initialize($config);``` to init the singleton instance
- ```WebApp::instance()->wp_theme``` to get the component WpTheme to create your theme. Hooks created using ```WebApp::instance()->componennt_name->method_name()``` can be de-registered, e.g ```remove_action( $tag, [WebApp::instance()->componennt_name, 'method_name'])```  

###Installation
- ```composer install``` to install all dependencies