<?php

namespace Enpii_Base\Deps\Illuminate\Console\Events;

use Enpii_Base\Deps\Symfony\Component\Console\Input\InputInterface;
use Enpii_Base\Deps\Symfony\Component\Console\Output\OutputInterface;

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
     * @var \Enpii_Base\Deps\Symfony\Component\Console\Input\InputInterface|null
     */
    public $input;

    /**
     * The command output implementation.
     *
     * @var \Enpii_Base\Deps\Symfony\Component\Console\Output\OutputInterface|null
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
     * @param  \Enpii_Base\Deps\Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Enpii_Base\Deps\Symfony\Component\Console\Output\OutputInterface  $output
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
