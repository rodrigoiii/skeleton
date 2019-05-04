<?php

namespace Core\QueueJob;

use Pheanstalk\Pheanstalk;
use Core\QueueJob\Utilities\Console;

class Worker
{
    private $pheanstalk;

    public function __construct(Pheanstalk $pheanstalk)
    {
        $this->pheanstalk = $pheanstalk;
    }

    public function listen(array $test_tubes)
    {
        $host = $this->pheanstalk->getConnection()->getHost();

        if (!$this->pheanstalk->getConnection()->isServiceListening())
        {
            exit(Console::red("Cannot connect on host {$host}. Server is not available.") . PHP_EOL);
        }

        echo Console::green("Listening {$host} ...") . PHP_EOL;

        foreach ($test_tubes as $test_tube)
        {
            // make it good format
            $test_tube = str_replace("\\", "_", $test_tube);

            $this->pheanstalk->watch($test_tube);
        }

        while ($job = $this->pheanstalk->reserve())
        {
            echo Console::yellow("Processing ...") . PHP_EOL;

            $data = json_decode($job->getData());

            $namespace = get_app_namespace() . "QueueJob\\";
            $class = $namespace . str_replace("_", "\\", $data->job);
            $params = $data->params;

            try {
                if (!class_exists($class)) throw new \Exception("Class {$class} is not exist.", 1);

                $job_reflection_class = new \ReflectionClass($class);
                $class_instance = $job_reflection_class->newInstanceArgs($params);

                // optional method
                if (method_exists($class, "before"))
                {
                    $class_instance->before();
                    echo PHP_EOL;
                }

                // check required method
                if (!method_exists($class, "handle")) throw new \Exception("Error: handle method is required. Make sure handle method is existing in your job class.", 1);
                $class_instance->handle();
                echo PHP_EOL;

                // optional method
                if (method_exists($class, "after"))
                {
                    $class_instance->after();
                    echo PHP_EOL;
                }

                echo Console::green("done.") . PHP_EOL . PHP_EOL;
            } catch (\Exception $e) {
                echo Console::red($e->getMessage() . PHP_EOL);
            }

            $this->pheanstalk->delete($job);
        }
    }
}
