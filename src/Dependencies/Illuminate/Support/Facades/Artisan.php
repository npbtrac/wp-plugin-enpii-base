<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;

/**
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingDispatch queue(string $command, array $parameters = [])
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Console\ClosureCommand command(string $command, callable $callback)
 * @method static array all()
 * @method static int call(string $command, array $parameters = [], \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface|null $outputBuffer = null)
 * @method static int handle(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface $input, \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface|null $output = null)
 * @method static string output()
 * @method static void terminate(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface $input, int $status)
 *
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console\Kernel
 */
class Artisan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ConsoleKernelContract::class;
    }
}
