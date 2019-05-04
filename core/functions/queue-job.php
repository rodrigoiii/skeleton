<?php

use Core\QueueJob\Queuer;
use Pheanstalk\Pheanstalk;

/**
 * Skeleton Queue Job library
 *
 * @param  string $job_class This must be class that use Core\QueueJob\JobInterface interface
 * @return void
 */
function queue_job($job_class)
{
    $host = config('queue-job.host');
    $queuer = new Queuer(new Pheanstalk($host));

    // make it good format
    $job_class = str_replace("\\", "_", $job_class);
    $queuer->queue($job_class);
}
