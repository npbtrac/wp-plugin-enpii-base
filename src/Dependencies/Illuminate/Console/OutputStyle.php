<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Console;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Style\SymfonyStyle;

class OutputStyle extends SymfonyStyle
{
    /**
     * The output instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * Create a new Console OutputStyle instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        parent::__construct($input, $output);
    }

    /**
     * Returns whether verbosity is quiet (-q).
     *
     * @return bool
     */
    public function isQuiet()
    {
        return $this->output->isQuiet();
    }

    /**
     * Returns whether verbosity is verbose (-v).
     *
     * @return bool
     */
    public function isVerbose()
    {
        return $this->output->isVerbose();
    }

    /**
     * Returns whether verbosity is very verbose (-vv).
     *
     * @return bool
     */
    public function isVeryVerbose()
    {
        return $this->output->isVeryVerbose();
    }

    /**
     * Returns whether verbosity is debug (-vvv).
     *
     * @return bool
     */
    public function isDebug()
    {
        return $this->output->isDebug();
    }
}
