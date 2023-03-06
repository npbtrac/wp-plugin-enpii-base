<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\Filesystem;

/**
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem\Filesystem assertExists(string|array $path)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem\Filesystem assertMissing(string|array $path)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem\Filesystem cloud()
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem\Filesystem disk(string $name = null)
 * @method static array allDirectories(string|null $directory = null)
 * @method static array allFiles(string|null $directory = null)
 * @method static array directories(string|null $directory = null, bool $recursive = false)
 * @method static array files(string|null $directory = null, bool $recursive = false)
 * @method static bool append(string $path, string $data)
 * @method static bool copy(string $from, string $to)
 * @method static bool delete(string|array $paths)
 * @method static bool deleteDirectory(string $directory)
 * @method static bool exists(string $path)
 * @method static bool makeDirectory(string $path)
 * @method static bool move(string $from, string $to)
 * @method static bool prepend(string $path, string $data)
 * @method static bool put(string $path, string|resource $contents, mixed $options = [])
 * @method static string|false putFile(string $path, \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\File|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\UploadedFile|string $file, mixed $options = [])
 * @method static string|false putFileAs(string $path, \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\File|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\UploadedFile|string $file, string $name, mixed $options = [])
 * @method static bool setVisibility(string $path, string $visibility)
 * @method static bool writeStream(string $path, resource $resource, array $options = [])
 * @method static int lastModified(string $path)
 * @method static int size(string $path)
 * @method static resource|null readStream(string $path)
 * @method static string get(string $path)
 * @method static string getVisibility(string $path)
 * @method static string temporaryUrl(string $path, \DateTimeInterface $expiration, array $options = [])
 * @method static string url(string $path)
 *
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Filesystem\FilesystemManager
 */
class Storage extends Facade
{
    /**
     * Replace the given disk with a local testing disk.
     *
     * @param  string|null  $disk
     * @param  array  $config
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem\Filesystem
     */
    public static function fake($disk = null, array $config = [])
    {
        $disk = $disk ?: static::$app['config']->get('filesystems.default');

        (new Filesystem)->cleanDirectory(
            $root = wp_app_storage_path('framework/testing/disks/'.$disk)
        );

        static::set($disk, $fake = static::createLocalDriver(array_merge($config, [
            'root' => $root,
        ])));

        return $fake;
    }

    /**
     * Replace the given disk with a persistent local testing disk.
     *
     * @param  string|null  $disk
     * @param  array  $config
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Filesystem\Filesystem
     */
    public static function persistentFake($disk = null, array $config = [])
    {
        $disk = $disk ?: static::$app['config']->get('filesystems.default');

        static::set($disk, $fake = static::createLocalDriver(array_merge($config, [
            'root' => wp_app_storage_path('framework/testing/disks/'.$disk),
        ])));

        return $fake;
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'filesystem';
    }
}
