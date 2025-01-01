<?php

namespace Hyvor\LaravelSafeScheduler;

class SafeSchedule
{

    /** @var ConfiguredJob[]  */
    private array $jobs = [];

    public static function job(string $jobName, string $key = null): ConfiguredJob
    {
        /** @var SafeSchedule $schedule */
        $schedule = app(SafeSchedule::class);
        return $schedule->addJob($jobName, $key);
    }

    /**
     * Schedule a new job.
     *
     * @param string $job The job to schedule. ex: `ClearDataJob::class`
     * @param string|null $key
     *  The unique key for the job.
     *  If not provided, the job name will be used.
     *  If you have the same job for multiple intervals, you should provide a unique key.
     */
    public function addJob(
        string $jobName,
        string $key = null
    ): ConfiguredJob
    {
        $key ??= $jobName;
        $job = new ConfiguredJob($jobName, $key);

        $this->jobs[] = $job;

        return $job;
    }

    /**
     * Get all the jobs.
     * @return ConfiguredJob[]
     */
    public function getJobs(): array
    {
        return $this->jobs;
    }

}