<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console\Events;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface;

class CommandFinished
{
    /**
     * The command name.
     *
     * @var string
     */
    public $command;

    /**
     * The console input implementation.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface|null
     */
    public $input;

    /**
     * The command output implementation.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface|null
     */
    public $output;

    /**
     * The command exit code.
     *
     * @var int
     */
    public $exitCode;

    /**
     * Create a new event instance.
     *
     * @param  string  $command
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface  $output
     * @param  int  $exitCode
     * @return void
     */
    public function __construct($command, InputInterface $input, OutputInterface $output, $exitCode)
    {
        $this->input = $input;
        $this->output = $output;
        $this->command = $command;
        $this->exitCode = $exitCode;
    }
}
