<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Concerns;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\ArrayInput;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\NullOutput;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface;

trait CallsCommands
{
    /**
     * Resolve the console command instance for the given command.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Command\Command|string  $command
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Command\Command
     */
    abstract protected function resolveCommand($command);

    /**
     * Call another console command.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Command\Command|string  $command
     * @param  array  $arguments
     * @return int
     */
    public function call($command, array $arguments = [])
    {
        return $this->runCommand($command, $arguments, $this->output);
    }

    /**
     * Call another console command silently.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Command\Command|string  $command
     * @param  array  $arguments
     * @return int
     */
    public function callSilent($command, array $arguments = [])
    {
        return $this->runCommand($command, $arguments, new NullOutput);
    }

    /**
     * Run the given the console command.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Command\Command|string  $command
     * @param  array  $arguments
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function runCommand($command, array $arguments, OutputInterface $output)
    {
        $arguments['command'] = $command;

        return $this->resolveCommand($command)->run(
            $this->createInputFromArguments($arguments), $output
        );
    }

    /**
     * Create an input instance from the given arguments.
     *
     * @param  array  $arguments
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\ArrayInput
     */
    protected function createInputFromArguments(array $arguments)
    {
        return tap(new ArrayInput(array_merge($this->context(), $arguments)), function ($input) {
            if ($input->getParameterOption('--no-interaction')) {
                $input->setInteractive(false);
            }
        });
    }

    /**
     * Get all of the context passed to the command.
     *
     * @return array
     */
    protected function context()
    {
        return wp_app_collect($this->option())->only([
            'ansi',
            'no-ansi',
            'no-interaction',
            'quiet',
            'verbose',
        ])->filter()->mapWithKeys(function ($value, $key) {
            return ["--{$key}" => $value];
        })->all();
    }
}
