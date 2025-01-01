<?php

namespace Hyvor\LaravelSafeScheduler;

use Illuminate\Console\Scheduling\ManagesFrequencies;

class ConfiguredJob
{

    use ManagesFrequencies;

    // default to run every minute
    public $expression = '* * * * *';

    public function __construct(
        public string $job,
        public string $key,
    ) {
    }

}