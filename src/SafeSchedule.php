<?php

namespace Hyvor\LaravelSafeScheduler;

class SafeSchedule
{

    /**
     * Schedule a new job.
     *
     * @param string $job The job to schedule. ex: `ClearDataJob::class`
     * @param string|null $key
     *  The unique key for the job.
     *  If not provided, the job name will be used.
     *  If you have the same job for multiple intervals, you should provide a unique key.
     */
    public function job(
        string $job,
        string $key = null
    ): ConfiguredJob
    {
        $key ??= $job;

        return new ConfiguredJob($job, $key);
    }

}