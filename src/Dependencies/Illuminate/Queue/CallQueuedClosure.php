<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Queue;

use Closure;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Bus\Queueable;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\Container;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Queue\ShouldQueue;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\Dispatchable;
use ReflectionFunction;

class CallQueuedClosure implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The serializable Closure instance.
     *
     * @var \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\SerializableClosure
     */
    public $closure;

    /**
     * Indicate if the job should be deleted when models are missing.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\SerializableClosure  $closure
     * @return void
     */
    public function __construct(SerializableClosure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * Create a new job instance.
     *
     * @param  \Closure  $job
     * @return self
     */
    public static function create(Closure $job)
    {
        return new self(new SerializableClosure($job));
    }

    /**
     * Execute the job.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\Container  $container
     * @return void
     */
    public function handle(Container $container)
    {
        $container->call($this->closure->getClosure());
    }

    /**
     * Get the display name for the queued job.
     *
     * @return string
     */
    public function displayName()
    {
        $reflection = new ReflectionFunction($this->closure->getClosure());

        return 'Closure ('.basename($reflection->getFileName()).':'.$reflection->getStartLine().')';
    }
}
