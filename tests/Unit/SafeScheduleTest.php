<?php

namespace Hyvor\LaravelSafeScheduler\Tests\Unit;

use Hyvor\LaravelSafeScheduler\SafeSchedule;
use Hyvor\LaravelSafeScheduler\Tests\Jobs\BasicJob;
use Hyvor\LaravelSafeScheduler\Tests\TestCase;

class SafeScheduleTest extends TestCase
{

    public function testConfiguredJobWithExpression(): void
    {

        $schedule = new SafeSchedule();
        $job = $schedule->job(BasicJob::class)->monthlyOn(1);
        $this->assertEquals('0 0 1 * *', $job->expression);

    }

}