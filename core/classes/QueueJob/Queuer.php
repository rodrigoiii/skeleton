<?php

namespace Core\QueueJob;

use Pheanstalk\Pheanstalk;

class Queuer
{
    private $pheanstalk;

    public function __construct(Pheanstalk $pheanstalk)
    {
        $this->pheanstalk = $pheanstalk;
    }

    public function queue($job, $params = [])
    {
        // make it good format
        $job = str_replace("\\", "_", $job);
        $this->pheanstalk->useTube($job)->put(json_encode(compact('job', 'params')));
    }
}
