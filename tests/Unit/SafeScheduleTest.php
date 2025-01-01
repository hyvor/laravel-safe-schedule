<?php

namespace Hyvor\LaravelSafeSchedule\Tests\Unit;

use Hyvor\LaravelSafeSchedule\SafeSchedule;
use Hyvor\LaravelSafeSchedule\Tests\Jobs\BasicJob;
use Hyvor\LaravelSafeSchedule\Tests\TestCase;

class SafeScheduleTest extends TestCase
{

    public function testConfiguredJobWithExpression(): void
    {

        $schedule = new SafeSchedule();
        $job = $schedule->job(BasicJob::class)->monthlyOn(1);
        $this->assertEquals('0 0 1 * *', $job->expression);

    }

}