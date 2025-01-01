<?php

namespace Hyvor\LaravelSafeSchedule\Command;

use Hyvor\LaravelSafeSchedule\ConfiguredJob;
use Hyvor\LaravelSafeSchedule\SafeSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RunCommand extends Command
{

    protected $signature = 'safe-schedule:run';

    protected $description = 'Run the safe schedule. It checks if there are any jobs to be dispatched and dispatches them.';

    public function handle(SafeSchedule $schedule): void
    {

        $jobs = $schedule->getJobs();

        $cacheKeys = array_map(fn(ConfiguredJob $job) => $job->cacheKey(), $jobs);
        $lastRunUnixTimestamps = cache()->many($cacheKeys);

        foreach ($jobs as $job) {
            $lastRunUnix = $lastRunUnixTimestamps[$job->cacheKey()] ?? 0;
            $lastRunUnix = intval($lastRunUnix);

            try {
                $shouldHaveRunUnix = $job->getPreviousRunUnixTimestamp();
            } catch (\Exception $e) {
                Log::critical('Failed to get previous run timestamp for job: ' . $job->key, [
                    'exception' => $e
                ]);
                continue;
            }

            if ($lastRunUnix < $shouldHaveRunUnix) {
                DB::transaction(function () use ($job) {
                    $job->dispatch();
                    cache()->put($job->cacheKey(), time());
                });
            }
        }

    }

}