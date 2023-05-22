<?php

namespace Enpii_Base\Deps\Illuminate\Foundation\Bootstrap;

use Enpii_Base\Deps\Dotenv\Dotenv;
use Enpii_Base\Deps\Dotenv\Exception\InvalidFileException;
use Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application;
use Enpii_Base\Deps\Illuminate\Support\Env;
use Enpii_Base\Deps\Symfony\Component\Console\Input\ArgvInput;
use Enpii_Base\Deps\Symfony\Component\Console\Output\ConsoleOutput;

class LoadEnvironmentVariables
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if ($app->configurationIsCached()) {
            return;
        }

        $this->checkForSpecificEnvironmentFile($app);

        try {
            $this->createDotenv($app)->safeLoad();
        } catch (InvalidFileException $e) {
            $this->writeErrorAndDie($e);
        }
    }

    /**
     * Detect if a custom environment file matching the APP_ENV exists.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    protected function checkForSpecificEnvironmentFile($app)
    {
        if ($app->runningInConsole() && ($input = new ArgvInput)->hasParameterOption('--env')) {
            if ($this->setEnvironmentFilePath(
                $app, $app->environmentFile().'.'.$input->getParameterOption('--env')
            )) {
                return;
            }
        }

        $environment = Env::get('APP_ENV');

        if (! $environment) {
            return;
        }

        $this->setEnvironmentFilePath(
            $app, $app->environmentFile().'.'.$environment
        );
    }

    /**
     * Load a custom environment file.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
     * @param  string  $file
     * @return bool
     */
    protected function setEnvironmentFilePath($app, $file)
    {
        if (file_exists($app->environmentPath().'/'.$file)) {
            $app->loadEnvironmentFrom($file);

            return true;
        }

        return false;
    }

    /**
     * Create a Enpii_Base\Deps\Dotenv instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Foundation\Application  $app
     * @return \Enpii_Base\Deps\Dotenv\Dotenv
     */
    protected function createDotenv($app)
    {
        return Dotenv::create(
            Env::getRepository(),
            $app->environmentPath(),
            $app->environmentFile()
        );
    }

    /**
     * Write the error information to the screen and exit.
     *
     * @param  \Enpii_Base\Deps\Dotenv\Exception\InvalidFileException  $e
     * @return void
     */
    protected function writeErrorAndDie(InvalidFileException $e)
    {
        $output = (new ConsoleOutput)->getErrorOutput();

        $output->writeln('The environment file is invalid!');
        $output->writeln($e->getMessage());

        exit(1);
    }
}
