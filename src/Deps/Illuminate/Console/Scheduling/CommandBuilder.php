<?php

namespace Enpii_Base\Deps\Illuminate\Console\Scheduling;

use Enpii_Base\Deps\Illuminate\Console\Application;
use Enpii_Base\Deps\Illuminate\Support\ProcessUtils;

class CommandBuilder
{
    /**
     * Build the command for the given event.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Console\Scheduling\Event  $event
     * @return string
     */
    public function buildCommand(Event $event)
    {
        if ($event->runInBackground) {
            return $this->buildBackgroundCommand($event);
        }

        return $this->buildForegroundCommand($event);
    }

    /**
     * Build the command for running the event in the foreground.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Console\Scheduling\Event  $event
     * @return string
     */
    protected function buildForegroundCommand(Event $event)
    {
        $output = ProcessUtils::escapeArgument($event->output);

        return $this->ensureCorrectUser(
            $event, $event->command.($event->shouldAppendOutput ? ' >> ' : ' > ').$output.' 2>&1'
        );
    }

    /**
     * Build the command for running the event in the background.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Console\Scheduling\Event  $event
     * @return string
     */
    protected function buildBackgroundCommand(Event $event)
    {
        $output = ProcessUtils::escapeArgument($event->output);

        $redirect = $event->shouldAppendOutput ? ' >> ' : ' > ';

        $finished = Application::formatCommandString('schedule:finish').' "'.$event->mutexName().'"';

        if (windows_os()) {
            return 'start /b cmd /c "('.$event->command.' & '.$finished.' "%errorlevel%")'.$redirect.$output.' 2>&1"';
        }

        return $this->ensureCorrectUser($event,
            '('.$event->command.$redirect.$output.' 2>&1 ; '.$finished.' "$?") > '
            .ProcessUtils::escapeArgument($event->getDefaultOutput()).' 2>&1 &'
        );
    }

    /**
     * Finalize the event's command syntax with the correct user.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Console\Scheduling\Event  $event
     * @param  string  $command
     * @return string
     */
    protected function ensureCorrectUser(Event $event, $command)
    {
        return $event->user && ! windows_os() ? 'sudo -u '.$event->user.' -- sh -c \''.$command.'\'' : $command;
    }
}