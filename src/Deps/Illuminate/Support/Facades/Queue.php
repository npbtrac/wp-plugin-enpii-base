<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

use Enpii_Base\Deps\Illuminate\Support\Testing\Fakes\QueueFake;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Queue\Job|null pop(string $queue = null)
 * @method static \Enpii_Base\Deps\Illuminate\Contracts\Queue\Queue setConnectionName(string $name)
 * @method static int size(string $queue = null)
 * @method static mixed bulk(array $jobs, mixed $data = '', string $queue = null)
 * @method static mixed later(\DateTimeInterface|\DateInterval|int $delay, string|object $job, mixed $data = '', string $queue = null)
 * @method static mixed laterOn(string $queue, \DateTimeInterface|\DateInterval|int $delay, string|object $job, mixed $data = '')
 * @method static mixed push(string|object $job, mixed $data = '', $queue = null)
 * @method static mixed pushOn(string $queue, string|object $job, mixed $data = '')
 * @method static mixed pushRaw(string $payload, string $queue = null, array $options = [])
 * @method static string getConnectionName()
 * @method static void assertNotPushed(string $job, callable $callback = null)
 * @method static void assertNothingPushed()
 * @method static void assertPushed(string $job, callable|int $callback = null)
 * @method static void assertPushedOn(string $queue, string $job, callable|int $callback = null)
 * @method static void assertPushedWithChain(string $job, array $expectedChain = [], callable $callback = null)
 *
 * @see \Enpii_Base\Deps\Illuminate\Queue\QueueManager
 * @see \Enpii_Base\Deps\Illuminate\Queue\Queue
 */
class Queue extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return \Enpii_Base\Deps\Illuminate\Support\Testing\Fakes\QueueFake
     */
    public static function fake()
    {
        static::swap($fake = new QueueFake(static::getFacadeApplication()));

        return $fake;
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'queue';
    }
}
