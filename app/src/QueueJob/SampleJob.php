<?php

namespace App\QueueJob;

use Core\QueueJob\JobInterface;

class SampleJob implements JobInterface
{
    public function before()
    {
        // before job execute
        echo "execute " . __METHOD__;
    }

    public function handle()
    {
        // code
        echo "execute " . __METHOD__;
    }

    public function after()
    {
        // after job execute
        echo "execute " . __METHOD__;
    }
}
