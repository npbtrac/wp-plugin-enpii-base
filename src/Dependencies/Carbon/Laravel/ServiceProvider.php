<?php

/**
 * This file is part of the Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon\Laravel;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon\Carbon;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon\CarbonImmutable;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon\CarbonInterval;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon\CarbonPeriod;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Events\Dispatcher;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Carbon as IlluminateCarbon;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Date;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\EventDispatcher\EventDispatcher;
use Throwable;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /** @var callable|null */
    protected $appGetter = null;

    /** @var callable|null */
    protected $localeGetter = null;

    public function setAppGetter(?callable $appGetter): void
    {
        $this->appGetter = $appGetter;
    }

    public function setLocaleGetter(?callable $localeGetter): void
    {
        $this->localeGetter = $localeGetter;
    }

    public function boot()
    {
        $this->updateLocale();

        if (!$this->app->bound('events')) {
            return;
        }

        $service = $this;
        $events = $this->app['events'];

        if ($this->isEventDispatcher($events)) {
            $events->listen(class_exists('Illuminate\Foundation\Events\LocaleUpdated') ? 'Illuminate\Foundation\Events\LocaleUpdated' : 'locale.changed', function () use ($service) {
                $service->updateLocale();
            });
        }
    }

    public function updateLocale()
    {
        $locale = $this->getLocale();

        if ($locale === null) {
            return;
        }

        Carbon::setLocale($locale);
        CarbonImmutable::setLocale($locale);
        CarbonPeriod::setLocale($locale);
        CarbonInterval::setLocale($locale);

        if (class_exists(IlluminateCarbon::class)) {
            IlluminateCarbon::setLocale($locale);
        }

        if (class_exists(Date::class)) {
            try {
                $root = Date::getFacadeRoot();
                $root->setLocale($locale);
            } catch (Throwable $e) {
                // Non Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon class in use in Date facade
            }
        }
    }

    public function register()
    {
        // Needed for Laravel < 5.3 compatibility
    }

    protected function getLocale()
    {
        if ($this->localeGetter) {
            return ($this->localeGetter)();
        }

        $app = $this->getApp();
        $app = $app && method_exists($app, 'getLocale')
            ? $app
            : $this->getGlobalApp('translator');

        return $app ? $app->getLocale() : null;
    }

    protected function getApp()
    {
        if ($this->appGetter) {
            return ($this->appGetter)();
        }

        return $this->app ?? $this->getGlobalApp();
    }

    protected function getGlobalApp(...$args)
    {
        return \function_exists('wp_app') ? \wp_app(...$args) : null;
    }

    protected function isEventDispatcher($instance)
    {
        return $instance instanceof EventDispatcher
            || $instance instanceof Dispatcher
            || $instance instanceof DispatcherContract;
    }
}
