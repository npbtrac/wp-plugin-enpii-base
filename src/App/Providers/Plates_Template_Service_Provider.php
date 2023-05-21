<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Providers;

use Enpii\WP_Plugin\Enpii_Base\App\View\Plates\Engine;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Plates\Engine as PlatesEngine;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Plates\Template\Theme as PlatesTheme;

class Plates_Template_Service_Provider extends ServiceProvider {
	/**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // $app->singleton(PlatesEngine::class, function () use ($app) {
        //     $path = $app['config']['view.paths'][2];

        //     return new PlatesEngine($path, 'php');
        // });

		$app->singleton(PlatesEngine::class, function () use ($app) {
            $paths = wp_app_config('view.paths');

            // return new PlatesEngine($paths, 'php');
			$themes = [];
			// foreach ($paths as $tmp_index => $path) {
			// 	$themes[] = PlatesTheme::new($path, 'plate_theme_'.$tmp_index);
			// }
			for ($tmp_index = count($paths) - 1; $tmp_index>=0; $tmp_index--) {
				$themes[] = PlatesTheme::new($paths[$tmp_index], 'plate_theme_'.$tmp_index);
			}
			// $themes[] = PlatesTheme::new($paths[2], 'plate_theme_'.'2');
			// $themes[] = PlatesTheme::new($paths[0], 'plate_theme_'.'0');
			// $themes[] = PlatesTheme::new($paths[1], 'plate_theme_'.'1');


            return PlatesEngine::fromTheme(PlatesTheme::hierarchy($themes), 'php');
		});

        $app->resolving('view', function($view) use ($app) {
			/** @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\View\Factory $view */
            $view->addExtension('php', 'plates', function() use ($app) {
                return new Engine($app->make(PlatesEngine::class));
            });
        });
    }

}
