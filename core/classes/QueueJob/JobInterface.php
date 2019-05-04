<?php

namespace Core\QueueJob;

interface JobInterface
{
    public function handle();
}
