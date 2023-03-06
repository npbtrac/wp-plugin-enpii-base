<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

/**
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application loadEnvironmentFrom(string $file)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider register(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider|string $provider, bool $force = false)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider resolveProvider(string $provider)
 * @method static array getProviders(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\ServiceProvider|string $provider)
 * @method static bool configurationIsCached()
 * @method static bool hasBeenBootstrapped()
 * @method static bool isDownForMaintenance()
 * @method static bool routesAreCached()
 * @method static bool runningInConsole()
 * @method static bool runningUnitTests()
 * @method static bool shouldSkipMiddleware()
 * @method static string basePath()
 * @method static string bootstrapPath(string $path = '')
 * @method static string configPath(string $path = '')
 * @method static string databasePath(string $path = '')
 * @method static string detectEnvironment(callable $callback)
 * @method static string environmentFile()
 * @method static string environmentFilePath()
 * @method static string environmentPath()
 * @method static string getCachedConfigPath()
 * @method static string getCachedPackagesPath()
 * @method static string getCachedRoutesPath()
 * @method static string getCachedServicesPath()
 * @method static string getLocale()
 * @method static string getNamespace()
 * @method static string resourcePath(string $path = '')
 * @method static string storagePath(string $path = '')
 * @method static string version()
 * @method static string|bool environment(string|array ...$environments)
 * @method static void boot()
 * @method static void booted(callable $callback)
 * @method static void booting(callable $callback)
 * @method static void bootstrapWith(array $bootstrappers)
 * @method static void loadDeferredProviders()
 * @method static void registerConfiguredProviders()
 * @method static void registerDeferredProvider(string $provider, string $service = null)
 * @method static void setLocale(string $locale)
 * @method static void terminate()
 *
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application
 */
class App extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'app';
    }
}
