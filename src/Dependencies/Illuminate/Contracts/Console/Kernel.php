<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console;

interface Kernel
{
    /**
     * Handle an incoming console command.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface|null  $output
     * @return int
     */
    public function handle($input, $output = null);

    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface|null  $outputBuffer
     * @return int
     */
    public function call($command, array $parameters = [], $outputBuffer = null);

    /**
     * Queue an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingDispatch
     */
    public function queue($command, array $parameters = []);

    /**
     * Get all of the commands registered with the console.
     *
     * @return array
     */
    public function all();

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output();

    /**
     * Terminate the application.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface  $input
     * @param  int  $status
     * @return void
     */
    public function terminate($input, $status);
}
