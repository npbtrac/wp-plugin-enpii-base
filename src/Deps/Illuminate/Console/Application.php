<?php

namespace Enpii_Base\Deps\Illuminate\Console;

use Closure;
use Enpii_Base\Deps\Illuminate\Console\Events\ArtisanStarting;
use Enpii_Base\Deps\Illuminate\Console\Events\CommandFinished;
use Enpii_Base\Deps\Illuminate\Console\Events\CommandStarting;
use Enpii_Base\Deps\Illuminate\Contracts\Console\Application as ApplicationContract;
use Enpii_Base\Deps\Illuminate\Contracts\Container\Container;
use Enpii_Base\Deps\Illuminate\Contracts\Events\Dispatcher;
use Enpii_Base\Deps\Illuminate\Support\ProcessUtils;
use Enpii_Base\Deps\Symfony\Component\Console\Application as SymfonyApplication;
use Enpii_Base\Deps\Symfony\Component\Console\Command\Command as SymfonyCommand;
use Enpii_Base\Deps\Symfony\Component\Console\Exception\CommandNotFoundException;
use Enpii_Base\Deps\Symfony\Component\Console\Input\ArgvInput;
use Enpii_Base\Deps\Symfony\Component\Console\Input\ArrayInput;
use Enpii_Base\Deps\Symfony\Component\Console\Input\InputInterface;
use Enpii_Base\Deps\Symfony\Component\Console\Input\InputOption;
use Enpii_Base\Deps\Symfony\Component\Console\Input\StringInput;
use Enpii_Base\Deps\Symfony\Component\Console\Output\BufferedOutput;
use Enpii_Base\Deps\Symfony\Component\Console\Output\ConsoleOutput;
use Enpii_Base\Deps\Symfony\Component\Console\Output\OutputInterface;
use Enpii_Base\Deps\Symfony\Component\Process\PhpExecutableFinder;

class Application extends SymfonyApplication implements ApplicationContract
{
    /**
     * The Laravel application instance.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Container\Container
     */
    protected $laravel;

    /**
     * The output from the previous command.
     *
     * @var \Enpii_Base\Deps\Symfony\Component\Console\Output\BufferedOutput
     */
    protected $lastOutput;

    /**
     * The console application bootstrappers.
     *
     * @var array
     */
    protected static $bootstrappers = [];

    /**
     * The Event Dispatcher.
     *
     * @var \Enpii_Base\Deps\Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * Create a new Artisan console application.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Container\Container  $laravel
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Events\Dispatcher  $events
     * @param  string  $version
     * @return void
     */
    public function __construct(Container $laravel, Dispatcher $events, $version)
    {
        parent::__construct('Laravel Framework', $version);

        $this->laravel = $laravel;
        $this->events = $events;
        $this->setAutoExit(false);
        $this->setCatchExceptions(false);

        $this->events->dispatch(new ArtisanStarting($this));

        $this->bootstrap();
    }

    /**
     * {@inheritdoc}
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $commandName = $this->getCommandName(
            $input = $input ?: new ArgvInput
        );

        $this->events->dispatch(
            new CommandStarting(
                $commandName, $input, $output = $output ?: new ConsoleOutput
            )
        );

        $exitCode = parent::run($input, $output);

        $this->events->dispatch(
            new CommandFinished($commandName, $input, $output, $exitCode)
        );

        return $exitCode;
    }

    /**
     * Determine the proper PHP executable.
     *
     * @return string
     */
    public static function phpBinary()
    {
        return ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));
    }

    /**
     * Determine the proper Artisan executable.
     *
     * @return string
     */
    public static function artisanBinary()
    {
        return defined('ARTISAN_BINARY') ? ProcessUtils::escapeArgument(ARTISAN_BINARY) : 'artisan';
    }

    /**
     * Format the given command as a fully-qualified executable command.
     *
     * @param  string  $string
     * @return string
     */
    public static function formatCommandString($string)
    {
        return sprintf('%s %s %s', static::phpBinary(), static::artisanBinary(), $string);
    }

    /**
     * Register a console "starting" bootstrapper.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function starting(Closure $callback)
    {
        static::$bootstrappers[] = $callback;
    }

    /**
     * Bootstrap the console application.
     *
     * @return void
     */
    protected function bootstrap()
    {
        foreach (static::$bootstrappers as $bootstrapper) {
            $bootstrapper($this);
        }
    }

    /**
     * Clear the console application bootstrappers.
     *
     * @return void
     */
    public static function forgetBootstrappers()
    {
        static::$bootstrappers = [];
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @param  \Enpii_Base\Deps\Symfony\Component\Console\Output\OutputInterface|null  $outputBuffer
     * @return int
     *
     * @throws \Enpii_Base\Deps\Symfony\Component\Console\Exception\CommandNotFoundException
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        [$command, $input] = $this->parseCommand($command, $parameters);

        if (! $this->has($command)) {
            throw new CommandNotFoundException(sprintf('The command "%s" does not exist.', $command));
        }

        return $this->run(
            $input, $this->lastOutput = $outputBuffer ?: new BufferedOutput
        );
    }

    /**
     * Parse the incoming Artisan command and its input.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return array
     */
    protected function parseCommand($command, $parameters)
    {
        if (is_subclass_of($command, SymfonyCommand::class)) {
            $callingClass = true;

            $command = $this->laravel->make($command)->getName();
        }

        if (! isset($callingClass) && empty($parameters)) {
            $command = $this->getCommandName($input = new StringInput($command));
        } else {
            array_unshift($parameters, $command);

            $input = new ArrayInput($parameters);
        }

        return [$command, $input ?? null];
    }

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output()
    {
        return $this->lastOutput && method_exists($this->lastOutput, 'fetch')
                        ? $this->lastOutput->fetch()
                        : '';
    }

    /**
     * Add a command to the console.
     *
     * @param  \Enpii_Base\Deps\Symfony\Component\Console\Command\Command  $command
     * @return \Enpii_Base\Deps\Symfony\Component\Console\Command\Command
     */
    public function add(SymfonyCommand $command)
    {
        if ($command instanceof Command) {
            $command->setLaravel($this->laravel);
        }

        return $this->addToParent($command);
    }

    /**
     * Add the command to the parent instance.
     *
     * @param  \Enpii_Base\Deps\Symfony\Component\Console\Command\Command  $command
     * @return \Enpii_Base\Deps\Symfony\Component\Console\Command\Command
     */
    protected function addToParent(SymfonyCommand $command)
    {
        return parent::add($command);
    }

    /**
     * Add a command, resolving through the application.
     *
     * @param  string  $command
     * @return \Enpii_Base\Deps\Symfony\Component\Console\Command\Command
     */
    public function resolve($command)
    {
        return $this->add($this->laravel->make($command));
    }

    /**
     * Resolve an array of commands through the application.
     *
     * @param  array|mixed  $commands
     * @return $this
     */
    public function resolveCommands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        foreach ($commands as $command) {
            $this->resolve($command);
        }

        return $this;
    }

    /**
     * Get the default input definition for the application.
     *
     * This is used to add the --env option to every available command.
     *
     * @return \Enpii_Base\Deps\Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition()
    {
        return tap(parent::getDefaultInputDefinition(), function ($definition) {
            $definition->addOption($this->getEnvironmentOption());
        });
    }

    /**
     * Get the global environment option for the definition.
     *
     * @return \Enpii_Base\Deps\Symfony\Component\Console\Input\InputOption
     */
    protected function getEnvironmentOption()
    {
        $message = 'The environment the command should run under';

        return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, $message);
    }

    /**
     * Get the Laravel application instance.
     *
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application
     */
    public function getLaravel()
    {
        return $this->laravel;
    }
}