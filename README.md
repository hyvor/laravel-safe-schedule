# Laravel Safe Scheduler

**Laravel Safe Scheduler** is a fault-tolerant scheduler built on top of [Laravel's default scheduler](https://laravel.com/docs/11.x/scheduling) to make sure that the scheduled tasks are executed even if the server is down at the time of the scheduled task.

Laravel's default scheduler runs at specific intervals and checks if there are any tasks that need to be executed at that moment and then executes them. It is usually scheduled to run by the server's cron job. But, there could be many reasons why that could fail, such as:

- Server is down
- Time synchronization issues
- Temporary file system issues
- System resource constraints
- ...


Please note that this package's scope is limited:

- You can only run queued jobs, not commands nor closures.
- It guarantees that the job is pushed to the queue, but it does not track the job's execution status. You should handle the job's failure and retry logic in the job itself.
- It only supports the UTC timezone.

This package depends on the following Laravel features:

- [Queue](https://laravel.com/docs/11.x/queues): Jobs are dispatched here.
- [Scheduling](https://laravel.com/docs/11.x/scheduling): To frequently check for runnable jobs.
- [Cache](https://laravel.com/docs/11.x/cache): To store the timestamp of the last run of each job.

## Schedule Command

Add the `safe-scheduler:run` command to Laravel's scheduler:

```php
class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command('safe-scheduler:run')
            ->everyMinute()
            ->onOneServer();
    }
}
```

This command will check if there are any jobs that need to be executed, comparing with a timestamp stored in the database. If there are any, it will dispatch them to the queue.