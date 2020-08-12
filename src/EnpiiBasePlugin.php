<?php


namespace Enpiicom\WpPlugin\EnpiiBase;

use Enpiicom\WpPlugin\EnpiiBase\App\Exceptions\Handler;
use Enpiicom\WpPlugin\EnpiiBase\App\Http\Kernel as HttpKernel;
use Enpiicom\WpPlugin\EnpiiBase\App\Console\Kernel as ConsoleKernel;
use Enpiicom\WpPlugin\EnpiiBase\App\Http\Request;
use WP;
use Enpiicom\WpPlugin\EnpiiBase\Base\WpPluginServiceProvider;
use Enpiicom\WpPlugin\EnpiiBase\Helpers\ConfigHelper;

class EnpiiBasePlugin extends WpPluginServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Get config for this plugin from global config
        $config = ConfigHelper::getWpAppPluginConfig(get_called_class());
        $this->bindConfig($config);

        $this->registerHooks();
    }

    public function registerHooks()
    {
        add_action('init', [$this, 'registerWPRewriteRules'], 7);
        add_action('wp_loaded', [$this, 'handleWPApp'], 1);

        add_filter('query_vars', [$this, 'addQueryVars']);
    }

    /**
     * Parse request URL to get `wp_app_route` & `is_wp_app_request` variables
     *
     * @return mixed|null
     */
    public function getWPAppRoute()
    {
        $the_wp = new WP();
        $the_wp->parse_request();

        return $the_wp->query_vars['wp_app_route'] ?? null;
    }

    public function registerWPRewriteRules()
    {
        add_rewrite_rule("^wp-app/?$", [
            'is_wp_app_request' => 1,
            'wp_app_route' => '/',
        ], 'top');
        add_rewrite_rule("^wp-app/(.*)/?$", [
            'is_wp_app_request' => 1,
            'wp_app_route' => '$matches[1]',
        ], 'top');
    }

    public function handleWPApp()
    {
        $wpAppRoute = $this->getWPAppRoute();
        if (!empty($wpAppRoute)) {
            $wpApp = $this->app;
            $wpApp['env'] = config('app.env');

            $wpApp->singleton(
                \Illuminate\Contracts\Http\Kernel::class,
                HttpKernel::class
            );

            $wpApp->singleton(
                \Illuminate\Contracts\Console\Kernel::class,
                ConsoleKernel::class
            );

            $wpApp->singleton(
                \Illuminate\Contracts\Debug\ExceptionHandler::class,
                Handler::class
            );

            /** @var \Enpiicom\WpPlugin\EnpiiBase\App\Http\Kernel $kernel */
            $kernel = $wpApp->make(\Illuminate\Contracts\Http\Kernel::class);

            $response = $kernel->handle(
                $request = Request::capture()
            );

            $response->send();

            $kernel->terminate($request, $response);
        }
        dump($wpAppRoute);

        die('asdf');
    }

    public function addQueryVars($queryVars)
    {
        $queryVars[] = "is_wp_app_request";
        $queryVars[] = "wp_app_route";

        return $queryVars;
    }
}
