<?php

namespace Enpii_Base\Deps\Illuminate\Support\Facades;

use Enpii_Base\Deps\Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;

/**
 * @method static \Enpii_Base\Deps\Illuminate\Foundation\Bus\PendingDispatch queue(string $command, array $parameters = [])
 * @method static \Enpii_Base\Deps\Illuminate\Foundation\Console\ClosureCommand command(string $command, callable $callback)
 * @method static array all()
 * @method static int call(string $command, array $parameters = [], \Enpii_Base\Deps\Symfony\Component\Console\Output\OutputInterface|null $outputBuffer = null)
 * @method static int handle(\Enpii_Base\Deps\Symfony\Component\Console\Input\InputInterface $input, \Enpii_Base\Deps\Symfony\Component\Console\Output\OutputInterface|null $output = null)
 * @method static string output()
 * @method static void terminate(\Enpii_Base\Deps\Symfony\Component\Console\Input\InputInterface $input, int $status)
 *
 * @see \Enpii_Base\Deps\Illuminate\Contracts\Console\Kernel
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
