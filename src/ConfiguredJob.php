<?php

namespace Hyvor\LaravelSafeScheduler;

use Cron\CronExpression;
use Illuminate\Console\Scheduling\ManagesFrequencies;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Container\BindingResolutionException;

class ConfiguredJob
{

    use ManagesFrequencies;

    /**
     * The cron expression representing the job's frequency.
     */
    public $expression = '* * * * *';

    /**
     * Callbacks to call after the job is dispatched.
     * @var callable[]
     */
    private array $then = [];

    public function __construct(
        public string $jobName,
        public string $key,
    ) {
    }

    /**
     * Call the given callback after the job is dispatched.
     * This does not mean the job is successful, nor it is even completed.
     * It merely means the job is dispatched to the queue successfully to be consumed by a worker.
     *
     * @param callable(): void $callback
     */
    public function then(callable $callback): static
    {
        return $this;
    }

    /**
     * @param callable(): void $callback
     */
    public function catch(callable $callback): static
    {
        return $this;
    }

    /**
     * The key to store the last run timestamp in the cache.
     */
    public function cacheKey(): string
    {
        return 'safe-scheduler:' . $this->key;
    }

    /**
     * @throws \Exception
     */
    public function getPreviousRunUnixTimestamp(): int
    {
        $expr = new CronExpression($this->expression);
        return $expr->getPreviousRunDate()->getTimestamp();
    }

    /**
     * @throws \Exception
     */
    public function dispatch(): void
    {
        $job = app()->make($this->jobName);
        app(Dispatcher::class)->dispatch($job);
    }

}