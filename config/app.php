<?php

return [
    'name' => env("APP_NAME"),
    'env' => env("APP_ENV"),
    'status_up' => env("APP_STATUS_UP"),

    'debug' => is_dev()
];
